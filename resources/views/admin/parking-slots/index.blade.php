@extends('admin.layouts.app')

@section('title', 'Parking Slots Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="h4 mb-0">
        <i class="bi bi-p-square me-2"></i> Parking Slots Management
    </h2>
    <a href="{{ route('admin.parking-slots.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-circle me-1"></i> Add New Slot
    </a>
</div>

<!-- Search and Filters -->
<div class="card card-custom mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label small text-muted">Search</label>
                <input type="text" name="search" class="form-control" 
                       value="{{ request('search') }}" placeholder="Search slot number or location...">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Status</label>
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Occupied" {{ request('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Min Price</label>
                <input type="number" name="min_price" class="form-control" 
                       value="{{ request('min_price') }}" placeholder="Min price" step="0.01">
            </div>
            <div class="col-md-2">
                <label class="form-label small text-muted">Max Price</label>
                <input type="number" name="max_price" class="form-control" 
                       value="{{ request('max_price') }}" placeholder="Max price" step="0.01">
            </div>
            <div class="col-md-3">
                <label class="form-label small text-muted">&nbsp;</label><br>
                <button type="submit" class="btn btn-primary-custom">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-outline-secondary">
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

<!-- Parking Slots Table -->
<div class="card card-custom">
    <div class="card-header bg-white">
        <h5 class="card-title mb-0">
            <i class="bi bi-list-ul me-2"></i> Parking Slots ({{ $parkingSlots->count() }})
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-hash me-1"></i> Slot ID</th>
                        <th><i class="bi bi-123 me-1"></i> Slot Number</th>
                        <th><i class="bi bi-geo-alt me-1"></i> Location</th>
                        <th><i class="bi bi-circle-fill me-1"></i> Status</th>
                        <th><i class="bi bi-currency-dollar me-1"></i> Price/Hour</th>
                        <th><i class="bi bi-gear me-1"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parkingSlots as $slot)
                    <tr>
                        <td class="fw-bold text-primary">#{{ $slot->slotID }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ $slot->slotNumber }}</span>
                        </td>
                        <td>{{ $slot->location }}</td>
                        <td>
                            <span class="badge badge-custom bg-{{ 
                                $slot->status == 'Available' ? 'success' : 
                                ($slot->status == 'Occupied' ? 'danger' : 'warning') 
                            }}">
                                <i class="bi bi-{{ 
                                    $slot->status == 'Available' ? 'check-circle' : 
                                    ($slot->status == 'Occupied' ? 'x-circle' : 'tools') 
                                }} me-1"></i>
                                {{ $slot->status }}
                            </span>
                        </td>
                        <td class="fw-bold">${{ number_format($slot->pricePerHour, 2) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.parking-slots.edit', $slot->slotID) }}" 
                                   class="btn btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.parking-slots.destroy', $slot->slotID) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to delete this slot?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted d-block mb-2"></i>
                            <span class="text-muted">No parking slots found.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection