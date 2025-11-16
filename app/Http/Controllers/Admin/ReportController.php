<?php
// app/Http/Controllers/Admin/ReportController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ParkingSlot;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Reservation::with(['user', 'parkingSlot', 'vehicle']);

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

            // Get filtered reservations for metrics
            $filteredReservations = (clone $query)->get();

            // Calculate metrics based on filtered data
            $totalRevenue = $filteredReservations->where('paymentStatus', 'Paid')->sum('totalCost') ?? 0;
            $activeReservations = $filteredReservations->where('reservationStatus', 'Active')->count();
            $completedReservations = $filteredReservations->where('reservationStatus', 'Completed')->count();
            $cancelledReservations = $filteredReservations->where('reservationStatus', 'Cancelled')->count();
            
            // Payment metrics
            $paidReservations = $filteredReservations->where('paymentStatus', 'Paid')->count();
            $pendingPayments = $filteredReservations->where('paymentStatus', 'Pending')->count();
            $failedPayments = $filteredReservations->where('paymentStatus', 'Failed')->count();

            // Get recent reservations from filtered query
            $recentReservations = $query->latest()->take(10)->get();

            // Parking slots data (unfiltered)
            $totalSlots = ParkingSlot::count();
            $occupiedSlots = ParkingSlot::where('status', 'Occupied')->count();
            $availableSlots = ParkingSlot::where('status', 'Available')->count();
            $maintenanceSlots = ParkingSlot::where('status', 'Maintenance')->count();
            $occupancyRate = $totalSlots > 0 ? ($occupiedSlots / $totalSlots) * 100 : 0;

            // Additional metrics
            $totalUsers = User::count();
            $totalVehicles = Vehicle::count();
            $avgReservationDuration = $filteredReservations->avg('totalHours') ?? 0;

            return view('admin.reports.index', compact(
                'totalRevenue',
                'activeReservations',
                'completedReservations',
                'cancelledReservations',
                'paidReservations',
                'pendingPayments',
                'failedPayments',
                'totalSlots',
                'occupiedSlots',
                'availableSlots',
                'maintenanceSlots',
                'occupancyRate',
                'totalUsers',
                'totalVehicles',
                'avgReservationDuration',
                'recentReservations'
            ));

        } catch (\Exception $e) {
            // Return default values in case of error
            return view('admin.reports.index', [
                'totalRevenue' => 0,
                'activeReservations' => 0,
                'completedReservations' => 0,
                'cancelledReservations' => 0,
                'paidReservations' => 0,
                'pendingPayments' => 0,
                'failedPayments' => 0,
                'totalSlots' => 0,
                'occupiedSlots' => 0,
                'availableSlots' => 0,
                'maintenanceSlots' => 0,
                'occupancyRate' => 0,
                'totalUsers' => 0,
                'totalVehicles' => 0,
                'avgReservationDuration' => 0,
                'recentReservations' => collect()
            ]);
        }
    }

    public function export(Request $request)
    {
        // Basic export functionality - you can expand this later
        $format = $request->get('format', 'pdf');
        
        return redirect()->route('admin.reports.index')
                        ->with('info', "Export as {$format} feature coming soon!");
    }
}
