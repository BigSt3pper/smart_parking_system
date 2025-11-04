<?php
// app/Http/Controllers/Admin/ReservationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Models\ParkingSlot;
use App\Models\Vehicle;
use Illuminate\Http\Request;

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

        //Filter by poayment status
        if ($request->has('paymentStatus') && $request->payment_status !='') {
            $query->where('paymentStatus', $request->payment_status);
        }

        $reservations = $query->latest()->get();
       
        $reservations = $query->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function create()
    {
        $users = User::all();
        $slots = ParkingSlot::where('status', 'Available')->get();
        $vehicles = Vehicle::all();
        
        return view('admin.reservations.create', compact('users', 'slots', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'slot_id' => 'required|exists:parking_slots,slotID',
            'vehicle_id' => 'required|exists:vehicles,vehicleID',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Calculate total hours and cost
        $start = \Carbon\Carbon::parse($request->start_time);
        $end = \Carbon\Carbon::parse($request->end_time);
        $totalHours = $end->diffInHours($start);
        
        $slot = ParkingSlot::find($request->slot_id);
        $totalCost = $totalHours * $slot->pricePerHour;

        Reservation::create([
            'userID' => $request->user_id,
            'slotID' => $request->slot_id,
            'vehicleID' => $request->vehicle_id,
            'startTime' => $request->start_time,
            'endTime' => $request->end_time,
            'totalHours' => $totalHours,
            'totalCost' => $totalCost,
            'reservationStatus' => 'Active',
            'paymentStatus' => 'Pending'
        ]);

        // Update slot status
        $slot->update(['status' => 'Occupied']);

        return redirect()->route('admin.reservations.index')
                        ->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['user', 'parkingSlot', 'vehicle']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $users = User::all();
        $slots = ParkingSlot::all();
        $vehicles = Vehicle::all();
        
        return view('admin.reservations.edit', compact('reservation', 'users', 'slots', 'vehicles'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'slot_id' => 'required|exists:parking_slots,slotID',
            'vehicle_id' => 'required|exists:vehicles,vehicleID',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'reservation_status' => 'required|in:Active,Cancelled,Completed',
            'payment_status' => 'required|in:Pending,Paid,Failed'
        ]);

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

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')
                        ->with('success', 'Reservation deleted successfully.');
    }
}