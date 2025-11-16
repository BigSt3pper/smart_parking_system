@extends('admin.layouts.app')

@section('title', 'Reservations Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-calendar-check me-2"></i> Reservations Management
    </h2>
    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-1"></i> Create Reservation
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Reservations</h6>
                        <h3 class="mb-0">{{ $reservations->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-calendar-check display-6 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Active</h6>
                        <h3 class="mb-0">{{ $reservations->where('reservationStatus', 'Active')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-play-circle display-6 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Pending Payment</h6>
                        <h3 class="mb-0">{{ $reservations->where('paymentStatus', 'Pending')->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-clock display-6 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">Total Revenue</h6>
                        <h3 class="mb-0">${{ number_format($reservations->where('paymentStatus', 'Paid')->sum('totalCost'), 2) }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-currency-dollar display-6 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="card card-custom mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control" 
                       value="{{ request('search') }}" placeholder="Search by ID, User, or Slot...">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
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
            <div class="col-md-3">
                <label class="form-label small text-muted">&nbsp;</label><br>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Reservations Table -->
<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i> Reservations ({{ $reservations->count() }})
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
                        <th><i class="bi bi-car-front me-1"></i> Vehicle</th>
                        <th><i class="bi bi-clock me-1"></i> Start Time</th>
                        <th><i class="bi bi-clock-history me-1"></i> End Time</th>
                        <th><i class="bi bi-currency-dollar me-1"></i> Total Cost</th>
                        <th><i class="bi bi-circle-fill me-1"></i> Status</th>
                        <th><i class="bi bi-credit-card me-1"></i> Payment</th>
                        <th><i class="bi bi-gear me-1"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                    <tr>
                        <td class="fw-bold text-primary">#{{ $reservation->reservationID }}</td>
                        <td>{{ $reservation->user->fullName ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <small class="text-muted">{{ $reservation->vehicle->plateNumber ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <div class="small">{{ $reservation->startTime->format('M d, Y') }}</div>
                            <div class="text-muted smaller">{{ $reservation->startTime->format('H:i A') }}</div>
                        </td>
                        <td>
                            <div class="small">{{ $reservation->endTime->format('M d, Y') }}</div>
                            <div class="text-muted smaller">{{ $reservation->endTime->format('H:i A') }}</div>
                        </td>
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
                                <i class="bi bi-{{ 
                                    $reservation->paymentStatus == 'Paid' ? 'check' : 
                                    ($reservation->paymentStatus == 'Pending' ? 'clock' : 'exclamation-triangle') 
                                }} me-1"></i>
                                {{ $reservation->paymentStatus }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.reservations.show', $reservation->reservationID) }}" 
                                   class="btn btn-outline-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.reservations.edit', $reservation->reservationID) }}" 
                                   class="btn btn-outline-warning" title="Edit Reservation">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.reservations.destroy', $reservation->reservationID) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete reservation #{{ $reservation->reservationID }}?')"
                                            title="Delete Reservation">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="bi bi-calendar-x display-4 text-muted d-block mb-3"></i>
                            <h5 class="text-muted">No reservations found</h5>
                            @if(request()->anyFilled(['search', 'status', 'payment_status']))
                                <p class="text-muted mb-3">Try adjusting your search filters</p>
                                <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-primary">
                                    Clear Filters
                                </a>
                            @else
                                <p class="text-muted mb-3">Get started by creating your first reservation</p>
                                <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary-custom">
                                    <i class="bi bi-plus-circle me-1"></i> Create Reservation
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
