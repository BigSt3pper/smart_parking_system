<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .card-custom:hover {
            transform: translateY(-2px);
        }
        .btn-primary-custom {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.3s;
        }
        .btn-primary-custom:hover {
            background: linear-gradient(45deg, #0056b3, #004085);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container-fluid {
            padding: 20px;
        }
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="bi bi-graph-up me-2"></i> Reports & Analytics
            </h2>
            <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary me-2">
            <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
        </a>
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard Report
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-custom stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Total Revenue</h6>
                                <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-currency-dollar display-6 text-primary"></i>
                            </div>
                        </div>
                        <small class="text-muted">All time</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Active Reservations</h6>
                                <h3 class="mb-0">{{ $activeReservations }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-calendar-check display-6 text-success"></i>
                            </div>
                        </div>
                        <small class="text-muted">Currently active</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Total Slots</h6>
                                <h3 class="mb-0">{{ $totalSlots }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-p-square display-6 text-info"></i>
                            </div>
                        </div>
                        <small class="text-muted">Parking capacity</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-custom stat-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Occupancy Rate</h6>
                                <h3 class="mb-0">{{ number_format($occupancyRate, 1) }}%</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-speedometer2 display-6 text-warning"></i>
                            </div>
                        </div>
                        <small class="text-muted">Current utilization</small>
                    </div>
                </div>
            </div>
        </div>
<!-- Success/Info Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-info-circle me-2"></i> {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Enhanced Date Range Filters -->
<div class="card card-custom mb-4">
    <div class="card-body">
        <h5 class="card-title mb-3">
            <i class="bi bi-funnel me-2"></i> Filter Reports
        </h5>
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small text-muted">Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Reservation Status</label>
                <select name="reservation_status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="Active" {{ request('reservation_status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ request('reservation_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('reservation_status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Payment Status</label>
                <select name="payment_status" class="form-control">
                    <option value="">All Payments</option>
                    <option value="Pending" {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Failed" {{ request('payment_status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">&nbsp;</label><br>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-graph-up me-1"></i> Generate
                </button>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </form>
        
        <!-- Quick Date Presets -->
        <div class="row mt-3">
            <div class="col-md-12">
                <small class="text-muted">Quick filters:</small>
                <a href="{{ route('admin.reports.index', ['start_date' => now()->subDays(7)->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}" 
                   class="btn btn-sm btn-outline-primary me-1">Last 7 Days</a>
                <a href="{{ route('admin.reports.index', ['start_date' => now()->subDays(30)->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}" 
                   class="btn btn-sm btn-outline-primary me-1">Last 30 Days</a>
                <a href="{{ route('admin.reports.index', ['start_date' => now()->startOfMonth()->format('Y-m-d'), 'end_date' => now()->endOfMonth()->format('Y-m-d')]) }}" 
                   class="btn btn-sm btn-outline-primary">This Month</a>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Revenue</h6>
                        <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar display-6 text-success"></i>
                    </div>
                </div>
                <small class="text-muted">From paid reservations</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Active Reservations</h6>
                        <h3 class="mb-0">{{ $activeReservations }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-play-circle display-6 text-primary"></i>
                    </div>
                </div>
                <small class="text-muted">Currently ongoing</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Slot Occupancy</h6>
                        <h3 class="mb-0">{{ number_format($occupancyRate, 1) }}%</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-speedometer2 display-6 text-info"></i>
                    </div>
                </div>
                <small class="text-muted">{{ $occupiedSlots }}/{{ $totalSlots }} occupied</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Avg. Duration</h6>
                        <h3 class="mb-0">{{ number_format($avgReservationDuration, 1) }}h</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock display-6 text-warning"></i>
                    </div>
                </div>
                <small class="text-muted">Per reservation</small>
            </div>
        </div>
    </div>
</div>

<!-- Status Breakdown Cards -->
<div class="row mb-4">
    <!-- Reservation Status Breakdown -->
    <div class="col-md-6">
        <div class="card card-custom h-100">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-calendar-check me-2"></i> Reservation Status Breakdown
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border-end">
                            <h4 class="text-success mb-1">{{ $activeReservations }}</h4>
                            <small class="text-muted">Active</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <h4 class="text-info mb-1">{{ $completedReservations }}</h4>
                            <small class="text-muted">Completed</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <h4 class="text-danger mb-1">{{ $cancelledReservations }}</h4>
                        <small class="text-muted">Cancelled</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment Status Breakdown -->
    <div class="col-md-6">
        <div class="card card-custom h-100">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-credit-card me-2"></i> Payment Status Breakdown
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="border-end">
                            <h4 class="text-success mb-1">{{ $paidReservations }}</h4>
                            <small class="text-muted">Paid</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="border-end">
                            <h4 class="text-warning mb-1">{{ $pendingPayments }}</h4>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <h4 class="text-danger mb-1">{{ $failedPayments }}</h4>
                        <small class="text-muted">Failed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Recent Reservations Table -->
        <div class="card card-custom">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history me-2"></i> Recent Reservations
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><i class="bi bi-hash me-1"></i> Reservation ID</th>
                                <th><i class="bi bi-person me-1"></i> User</th>
                                <th><i class="bi bi-p-square me-1"></i> Slot</th>
                                <th><i class="bi bi-clock me-1"></i> Duration</th>
                                <th><i class="bi bi-currency-dollar me-1"></i> Amount</th>
                                <th><i class="bi bi-circle-fill me-1"></i> Status</th>
                                <th><i class="bi bi-calendar me-1"></i> Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentReservations as $reservation)
                            <tr>
                                <td class="fw-bold text-primary">#{{ $reservation->reservationID }}</td>
                                <td>{{ $reservation->user->fullName ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</span>
                                </td>
                                <td>{{ $reservation->totalHours }} hours</td>
                                <td class="fw-bold">${{ number_format($reservation->totalCost, 2) }}</td>
                                <td>
                                    <span class="badge badge-custom bg-{{ $reservation->reservationStatus == 'Active' ? 'success' : ($reservation->reservationStatus == 'Completed' ? 'info' : 'secondary') }}">
                                        <i class="bi bi-{{ $reservation->reservationStatus == 'Active' ? 'play-circle' : ($reservation->reservationStatus == 'Completed' ? 'check-circle' : 'x-circle') }} me-1"></i>
                                        {{ $reservation->reservationStatus }}
                                    </span>
                                </td>
                                <td>{{ $reservation->createdAt->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                                    <span class="text-muted">No reservations found.</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<!-- Recent Reservations Table -->
<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-clock-history me-2"></i> Recent Reservations
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-hash me-1"></i> Reservation ID</th>
                        <th><i class="bi bi-person me-1"></i> User</th>
                        <th><i class="bi bi-p-square me-1"></i> Slot</th>
                        <th><i class="bi bi-clock me-1"></i> Duration</th>
                        <th><i class="bi bi-currency-dollar me-1"></i> Amount</th>
                        <th><i class="bi bi-circle-fill me-1"></i> Status</th>
                        <th><i class="bi bi-credit-card me-1"></i> Payment</th>
                        <th><i class="bi bi-calendar me-1"></i> Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReservations as $reservation)
                    <tr>
                        <td class="fw-bold text-primary">#{{ $reservation->reservationID }}</td>
                        <td>{{ $reservation->user->fullName ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</span>
                        </td>
                        <td>{{ $reservation->totalHours }} hours</td>
                        <td class="fw-bold">${{ number_format($reservation->totalCost, 2) }}</td>
                        <td>
                            <span class="badge badge-custom bg-{{ 
                                $reservation->reservationStatus == 'Active' ? 'success' : 
                                ($reservation->reservationStatus == 'Completed' ? 'info' : 'danger') 
                            }}">
                                <i class="bi bi-{{ 
                                    $reservation->reservationStatus == 'Active' ? 'play-circle' : 
                                    ($reservation->reservationStatus == 'Completed' ? 'check-circle' : 'x-circle') 
                                }} me-1"></i>
                                {{ $reservation->reservationStatus }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-custom bg-{{ 
                                $reservation->paymentStatus == 'Paid' ? 'success' : 
                                ($reservation->paymentStatus == 'Pending' ? 'warning' : 'danger') 
                            }}">
                                {{ $reservation->paymentStatus }}
                            </span>
                        </td>
                        <td>{{ $reservation->createdAt->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                            <span class="text-muted">No reservations found.</span>
                            @if(request()->anyFilled(['start_date', 'end_date', 'reservation_status', 'payment_status']))
                                <div class="mt-2">
                                    <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-outline-primary">
                                        Clear filters to see all reservations
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Export Options -->
<div class="card card-custom mt-4">
    <div class="card-body">
        <h5 class="card-title mb-3">
            <i class="bi bi-download me-2"></i> Export Options
        </h5>
        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('admin.reports.export') }}" method="GET" class="d-inline">
                <input type="hidden" name="format" value="excel">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
                </button>
            </form>
            <form action="{{ route('admin.reports.export') }}" method="GET" class="d-inline">
                <input type="hidden" name="format" value="pdf">
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Export to PDF
                </button>
            </form>
            <button onclick="window.print()" class="btn btn-info">
                <i class="bi bi-printer me-1"></i> Print Report
            </button>
        </div>
        <small class="text-muted mt-2 d-block">Note: Export features include current filter settings</small>
    </div>
</div>

<!-- Summary Section -->
@if(request()->anyFilled(['start_date', 'end_date', 'reservation_status', 'payment_status']))
<div class="card card-custom mt-4">
    <div class="card-body">
        <h5 class="card-title mb-3">
            <i class="bi bi-info-circle me-2"></i> Report Summary
        </h5>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Date Range:</strong> 
                    @if(request('start_date') && request('end_date'))
                        {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }} - {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                    @elseif(request('start_date'))
                        From {{ \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') }}
                    @elseif(request('end_date'))
                        Until {{ \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') }}
                    @else
                        All dates
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>Filters Applied:</strong> 
                    {{ request('reservation_status') ? 'Status: ' . request('reservation_status') . ', ' : '' }}
                    {{ request('payment_status') ? 'Payment: ' . request('payment_status') : '' }}
                    {{ !request('reservation_status') && !request('payment_status') ? 'No additional filters' : '' }}
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
</div>
@endif

<style>
@media print {
    .btn, .card-header, .alert, .form-control, .form-label {
        display: none !important;
    }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
    }
}
</style>
</html>
