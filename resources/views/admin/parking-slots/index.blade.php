<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slots - Smart Parking System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .card-custom { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .container-fluid { padding: 20px; }
        .btn-primary-custom { background: linear-gradient(45deg, #007bff, #0056b3); border: none; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-p-square me-2"></i> Parking Slots Management</h2>
            <div>
                <a href="{{ route('admin.parking-slots.create') }}" class="btn btn-primary-custom me-2">
                    <i class="bi bi-plus-circle me-1"></i> Add New Slot
                </a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Simple Filter Form -->
        <div class="card card-custom mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search by slot number or location..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Statuses</option>
                            <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Occupied" {{ request('status') == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="Maintenance" {{ request('status') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Price Range</label>
                        <input type="number" name="min_price" class="form-control" placeholder="Min price" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
        </div>

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