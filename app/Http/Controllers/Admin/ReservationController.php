<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\ParkingSlot;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of reservations.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'parkingSlot', 'vehicle']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('reservationID', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('fullName', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('parkingSlot', function ($q) use ($search) {
                      $q->where('slotNumber', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('vehicle', function ($q) use ($search) {
                      $q->where('NumberPlate', 'LIKE', "%{$search}%");
                  });
        }

        // Filter by reservation status
        if ($request->filled('status')) {
            $query->where('reservationStatus', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('paymentStatus', $request->payment_status);
        }

        // NOTE: your table uses createdAt (not created_at), so order by createdAt
        $reservations = $query->orderBy('createdAt', 'desc')->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new reservation.
     * Option B: admin supplies user & vehicle info in the form.
     */
    public function create()
    {
        // Only available slots should be selectable
        $slots = ParkingSlot::where('status', 'Available')->get();

        // For Option B we expect the admin to input user_name, user_email, license_plate, vehicle_model, etc.
        return view('admin.reservations.create', compact('slots'));
    }

    /**
     * Store a newly created reservation in storage.
     * Option B: create or reuse user and vehicle based on email / plate.
     */
    public function store(Request $request)
    {
        $request->validate([
            // user info (admin entered)
            'user_name'     => 'required|string|max:100',
            'user_email'    => 'required|email|max:100',
            // vehicle info (admin entered)
            'license_plate' => 'required|string|max:20',
            'vehicle_model' => 'nullable|string|max:50',
            // reservation fields
            'slot_id'       => 'required|exists:ParkingSlot,slotID',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date|after:start_time',
        ]);

        // Parse times
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);

        // Calculate total hours (use hours difference; you can adjust to round up if desired)
        $totalHours = $end->diffInHours($start);
        if ($totalHours === 0) {
            // If start and end are within an hour, count as 1 hour
            $totalHours = 1;
        }

        // Get slot and compute cost
        $slot = ParkingSlot::findOrFail($request->slot_id);
        $totalCost = $totalHours * $slot->pricePerHour;

        // Create or reuse the user (by email)
        $user = User::firstOrCreate(
            ['email' => $request->user_email],
            [
                'fullName' => $request->user_name,
                'password' => Hash::make(Str::random(12)), // random password for admin-created user
                'role' => 'Driver',
                'phoneNumber' => $request->filled('user_phone') ? $request->user_phone : null,
                // dateRegistered handled by DB default column 'dateRegistered'
            ]
        );

        // Create or reuse the vehicle (by NumberPlate)
        $vehicle = Vehicle::firstOrCreate(
            ['NumberPlate' => $request->license_plate],
            [
                'userID' => $user->userID,
                'model'  => $request->vehicle_model ?? 'Unknown',
                'color'  => $request->vehicle_color ?? 'Unknown',
            ]
        );

        // Create reservation
        $reservation = Reservation::create([
            'userID'            => $user->userID,
            'vehicleID'         => $vehicle->vehicleID,
            'slotID'            => $slot->slotID,
            'startTime'         => $start->toDateTimeString(),
            'endTime'           => $end->toDateTimeString(),
            'totalHours'        => $totalHours,
            'totalCost'         => $totalCost,
            'reservationStatus' => 'Active',
            'paymentStatus'     => 'Pending',
            // createdAt is handled by DB default in your migration
        ]);

        // Mark slot as occupied
        $slot->update(['status' => 'Occupied']);

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['user', 'parkingSlot', 'vehicle'])->findOrFail($id);

        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified reservation.
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);

        // We will allow changing slot (all slots) and reservation fields
        $users = User::all();
        $slots = ParkingSlot::all();
        $vehicles = Vehicle::all();

        return view('admin.reservations.edit', compact('reservation', 'users', 'slots', 'vehicles'));
    }

    /**
     * Update the specified reservation in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'user_id'            => 'required|exists:User,userID',
            'slot_id'            => 'required|exists:ParkingSlot,slotID',
            'vehicle_id'         => 'required|exists:Vehicle,vehicleID',
            'start_time'         => 'required|date',
            'end_time'           => 'required|date|after:start_time',
            'reservation_status' => 'required|in:Active,Cancelled,Completed',
            'payment_status'     => 'required|in:Pending,Paid,Failed'
        ]);

        // Parse times and recalc cost
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $totalHours = $end->diffInHours($start);
        if ($totalHours === 0) {
            $totalHours = 1;
        }

        $newSlot = ParkingSlot::findOrFail($request->slot_id);
        $totalCost = $totalHours * $newSlot->pricePerHour;

        // If slot changed, free the old slot and occupy the new one
        if ($reservation->slotID != $newSlot->slotID) {
            // Free old slot if exists
            $oldSlot = ParkingSlot::find($reservation->slotID);
            if ($oldSlot) {
                $oldSlot->update(['status' => 'Available']);
            }
            // Occupy new slot
            $newSlot->update(['status' => 'Occupied']);
        } else {
            // If same slot and reservation is being cancelled/completed, update its status accordingly below
            if (in_array($request->reservation_status, ['Cancelled', 'Completed'])) {
                $newSlot->update(['status' => 'Available']);
            } elseif ($request->reservation_status === 'Active') {
                $newSlot->update(['status' => 'Occupied']);
            }
        }

        // Update reservation
        $reservation->update([
            'userID'            => $request->user_id,
            'slotID'            => $request->slot_id,
            'vehicleID'         => $request->vehicle_id,
            'startTime'         => $start->toDateTimeString(),
            'endTime'           => $end->toDateTimeString(),
            'totalHours'        => $totalHours,
            'totalCost'         => $totalCost,
            'reservationStatus' => $request->reservation_status,
            'paymentStatus'     => $request->payment_status
        ]);

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified reservation from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Free up the parking slot before deleting reservation
        $slot = ParkingSlot::find($reservation->slotID);
        if ($slot) {
            $slot->update(['status' => 'Available']);
        }

        $reservation->delete();

        return redirect()->route('admin.reservations.index')
                         ->with('success', 'Reservation deleted successfully.');
    }
}
