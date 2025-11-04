<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ParkingSlot;
use App\Models\Reservation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalSlots' => ParkingSlot::count(),
            'activeReservations' => Reservation::where('reservationStatus', 'Active')->count(),
            'availableSlots' => ParkingSlot::where('status', 'Available')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
