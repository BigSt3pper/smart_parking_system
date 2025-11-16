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

/**
 * @method \Illuminate\Http\RedirectResponse redirectToRoute(string $name, array $parameters = [])
 */

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'parkingSlot']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('reservationID', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q) use($search) {
                        $q->where('fullName', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('parkingSlot', function($q) use ($search) {
                        $q->where('slotNumber', 'LIKE', "%{$search}%");
                  });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('reservationStatus', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('paymentStatus', $request->payment_status);
        }

        $reservations = $query->orderBy('createdAt', 'desc')->get();
        
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        // Only get available slots - no need for users and vehicles anymore
        $slots = ParkingSlot::where('status', 'Available')->get();
        
        return view('admin.reservations.create', compact('slots'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'user_name' => 'required|string|max:100',
        'user_email' => 'required|email|max:100',
        'vehicle_type' => 'required|string|max:50',
        'license_plate' => 'required|string|max:20',
        'slot_id' => 'required|exists:ParkingSlot,slotID',
        'start_time' => 'required|string',
        'end_time' => 'required|string',
    ]);

    // Manual date validation
    $startTime = $request->start_time;
    $endTime = $request->end_time;
    
    // Check if dates are in correct format (YYYY-MM-DDTHH:MM)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $startTime)) {
        return back()->withErrors(['start_time' => 'Invalid start time format. Use YYYY-MM-DDTHH:MM format.']);
    }
    
    if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $endTime)) {
        return back()->withErrors(['end_time' => 'Invalid end time format. Use YYYY-MM-DDTHH:MM format.']);
    }

    try {
        // Parse dates manually
        $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $startTime);
        $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $endTime);
        
        // Check if dates are valid
        if (!$startDateTime || !$endDateTime) {
            return back()->withErrors(['start_time' => 'Invalid date values provided.']);
        }
        
        // Check if end time is after start time
        if ($endDateTime <= $startDateTime) {
            return back()->withErrors(['end_time' => 'End time must be after start time.']);
        }
        
    } catch (\Exception $e) {
        return back()->withErrors(['start_time' => 'Date parsing error: ' . $e->getMessage()]);
    }

    // Calculate total hours and cost
    $totalHours = $endDateTime->diffInHours($startDateTime);
    
    $slot = ParkingSlot::find($request->slot_id);
    if (!$slot) {
        return back()->withErrors(['slot_id' => 'Selected parking slot not found.']);
    }
    $totalCost = $totalHours * $slot->pricePerHour;

    // First, find or create the user
    $user = User::firstOrCreate(
        ['email' => $request->user_email],
        [
            'fullName' => $request->user_name,
            'password' => Hash::make(Str::random(10)),
            'role' => 'Driver',
            'phoneNumber' => null,
        ]
    );

    // Find or create the vehicle
    $vehicle = Vehicle::firstOrCreate(
        ['NumberPlate' => $request->license_plate],
        [
            'userID' => $user->userID,
            'model' => $request->vehicle_type,
            'color' => 'Unknown',
        ]
    );

    // Create the reservation
    Reservation::create([
        'userID' => $user->userID,
        'slotID' => $request->slot_id,
        'vehicleID' => $vehicle->vehicleID,
        'startTime' => $startDateTime,
        'endTime' => $endDateTime,
        'totalHours' => $totalHours,
        'totalCost' => $totalCost,
        'reservationStatus' => 'Active',
        'paymentStatus' => 'Pending'
    ]);

    // Update slot status to Occupied
    $slot->update(['status' => 'Occupied']);

    return redirect()->route('admin.reservations.index')
                    ->with('success', 'Reservation created successfully.');
}

    public function show($id)
    {
        $reservation = Reservation::with(['user', 'parkingSlot', 'vehicle'])->findOrFail($id);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $users = User::all();
        $slots = ParkingSlot::all();
        $vehicles = Vehicle::all();
        
        return view('admin.reservations.edit', compact('reservation', 'users', 'slots', 'vehicles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:User,userID',
            'slot_id' => 'required|exists:ParkingSlot,slotID',
            'vehicle_id' => 'required|exists:Vehicle,vehicleID',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'reservation_status' => 'required|in:Active,Cancelled,Completed',
            'payment_status' => 'required|in:Pending,Paid,Failed'
        ]);

        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'userID' => $request->user_id,
            'slotID' => $request->slot_id,
            'vehicleID' => $request->vehicle_id,
            'startTime' => $request->start_time,
            'endTime' => $request->end_time,
            'reservationStatus' => $request->reservation_status,
            'paymentStatus' => $request->payment_status
        ]);

        return redirect()->route('admin.reservations.index')
                        ->with('success', 'Reservation updated successfully.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        
        return redirect()->route('admin.reservations.index')
                        ->with('success', 'Reservation deleted successfully.');
    }
}