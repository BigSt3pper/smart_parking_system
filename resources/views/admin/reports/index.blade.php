@extends('admin.layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-graph-up me-2"></i> Reports & Analytics
    </h2>
    <div>
        <a href="{{ route('admin.reports.export') }}" class="btn btn-success me-2">
            <i class="bi bi-download me-1"></i> Export
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

<!-- Enhanced Date Range Filters -->
<div class="card card-custom mb-4">
    <div class="card-body">
        <h5 class="card-title">
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
                <a href="{{ route('admin.reports.index', ['start_date' => now()->subDays(7)->format('Y-m-d')]) }}" 
                   class="btn btn-sm btn-outline-primary me-1">Last 7 Days</a>
                <a href="{{ route('admin.reports.index', ['start_date' => now()->subDays(30)->format('Y-m-d')]) }}" 
                   class="btn btn-sm btn-outline-primary me-1">Last 30 Days</a>
                <a href="{{ route('admin.reports.index', ['start_date' => now()->startOfMonth()->format('Y-m-d')]) }}" 
                   class="btn btn-sm btn-outline-primary">This Month</a>
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
                            <span class="badge badge-custom bg-{{ $reservation->reservationStatus == 'Active' ? 'success' : 'info' }}">
                                <i class="bi bi-{{ $reservation->reservationStatus == 'Active' ? 'play-circle' : 'check-circle' }} me-1"></i>
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

<!-- Export Options -->
<div class="card card-custom mt-4">
    <div class="card-body">
        <h5 class="card-title">
            <i class="bi bi-download me-2"></i> Export Reports
        </h5>
        <a href="#" class="btn btn-success me-2">
            <i class="bi bi-file-earmark-excel me-1"></i> Export to Excel
        </a>
        <a href="#" class="btn btn-danger me-2">
            <i class="bi bi-file-earmark-pdf me-1"></i> Export to PDF
        </a>
        <a href="#" class="btn btn-info">
            <i class="bi bi-printer me-1"></i> Print Report
        </a>
    </div>
</div>
@endsection