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
                <h5 class="card-title mb-0">Parking Slots ({{ $parkingSlots->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Slot ID</th>
                                <th>Slot Number</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Price/Hour</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parkingSlots as $slot)
                            <tr>
                                <td class="fw-bold">#{{ $slot->slotID }}</td>
                                <td class="fw-bold">{{ $slot->slotNumber }}</td>
                                <td>{{ $slot->location ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $slot->status == 'Available' ? 'success' : ($slot->status == 'Occupied' ? 'danger' : 'warning') }}">
                                        {{ $slot->status }}
                                    </span>
                                </td>
                                <td>${{ number_format($slot->pricePerHour, 2) }}</td>
                                <td>{{ $slot->lastUpdated ? $slot->lastUpdated->format('M d, Y H:i') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.parking-slots.edit', $slot) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.parking-slots.destroy', $slot) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                                    No parking slots found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>