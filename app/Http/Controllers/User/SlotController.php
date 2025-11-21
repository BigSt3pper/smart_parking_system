<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlotController extends Controller
{
    // Show available slots
    public function index()
    {
        $slots = ParkingSlot::where('status', 'available')->get();
        return view('user.index', compact('slots'));
    }

    // Booking form
    public function bookForm($id)
    {
        $slot = ParkingSlot::findOrFail($id);

        return view('user.slots.book', compact('slot'));
    }

    // Save booking
    public function storeBooking(Request $request, $id)
    {
        $slot = ParkingSlot::findOrFail($id);

        // create reservation
        Reservation::create([
            'user_id' => Auth::id(),
            'parking_slot_id' => $slot->id,
            'status' => 'active'
        ]);

        // update slot
        $slot->status = 'occupied';
        $slot->save();

        return redirect()->route('user.reservations')
                         ->with('success', 'Slot booked successfully');
    }
}
