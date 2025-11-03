<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        try {
            // USE Reservation model instead of Payment model
            $totalRevenue = Reservation::where('paymentStatus', 'Paid')->sum('totalCost') ?? 0;
            
            $activeReservations = Reservation::where('reservationStatus', 'Active')->count();
            
            $totalSlots = ParkingSlot::count();
            
            // Occupancy Rate
            $occupiedSlots = ParkingSlot::where('status', 'Occupied')->count();
            $occupancyRate = $totalSlots > 0 ? ($occupiedSlots / $totalSlots) * 100 : 0;
            
            // Recent Reservations
            $recentReservations = Reservation::with(['user', 'parkingSlot'])
                                            ->latest()
                                            ->take(10)
                                            ->get();

            return view('admin.reports.index', compact(
                'totalRevenue',
                'activeReservations', 
                'totalSlots',
                'occupancyRate',
                'recentReservations'
            ));
            
        } catch (\Exception $e) {
            // Fallback if there are errors
            return view('admin.reports.index', [
                'totalRevenue' => 0,
                'activeReservations' => 0,
                'totalSlots' => 0,
                'occupancyRate' => 0,
                'recentReservations' => collect() // Empty collection
            ]);
        }
    }

    public function export()
    {
        return redirect()->route('admin.reports.index')
                        ->with('success', 'Export feature coming soon!');
    }
}