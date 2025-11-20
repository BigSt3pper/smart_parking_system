<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->get();

        return view('user.reservations.index', compact('reservations'));
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->firstOrFail();

        // free the slot
        $reservation->slot->update(['status' => 'available']);

        $reservation->delete();

        return redirect()->back()->with('success', 'Reservation cancelled');
    }
}
