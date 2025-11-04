<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Reservation::query();
            // Date range filter
            if ($request->has('start_date') && $request->start_date != '') {
                $query->whereDate('createdAt', '>=', $request->start_date);
            }
            if ($request->has('end_date') && $request->end_date != '') {
                $query->whereDate('createdAt', '<=', $request->end_date);
            }
            // Filter by reservation status
            if ($request->has('reservation_status') && $request->reservation_status != '') {
                $query->where('reservationStatus', $request->reservation_status);
            }
            // Filter by payment status
            if ($request->has('payment_status') && $request->payment_status != '') {
                $query->where('paymentStatus', $request->payment_status);
            }
            // Calculate metrics based on filtered data
            $totalRevenue = (clone $query)->where('paymentStatus', 'Paid')->sum('totalCost') ?? 0;
            $activeReservations = (clone $query)->where('reservationStatus', 'Active')->count();
            // Get recent reservations from filtered query
            $recentReservations = $query->with(['user', 'parkingSlot'])
                                        ->latest()
                                        ->take(10)
                                        ->get();
            // Parking slots data (unfiltered)
            $totalSlots = ParkingSlot::count();
            $occupiedSlots = ParkingSlot::where('status', 'Occupied')->count();
            $occupancyRate = $totalSlots > 0 ? ($occupiedSlots / $totalSlots) * 100 : 0;
            return view('admin.reports.index', compact(
                'totalRevenue',
                'activeReservations', 
                'totalSlots',
                'occupancyRate',
                'recentReservations'
            ));
        } catch (\Exception $e) {
            return view('admin.reports.index', [
                'totalRevenue' => 0,
                'activeReservations' => 0,
                'totalSlots' => 0,
                'occupancyRate' => 0,
                'recentReservations' => collect()
            ]);
        }
    }

    public function export()
    {
        return redirect()->route('admin.reports.index')
                        ->with('success', 'Export feature coming soon!');
    }
}