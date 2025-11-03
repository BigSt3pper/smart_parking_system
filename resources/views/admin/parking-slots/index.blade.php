<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Slots - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Parking Slots Management</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.parking-slots.create') }}" class="btn btn-primary">
                    Add New Slot
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Slot ID</th>
                            <th>Slot Number</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Price/Hour</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parkingSlots as $slot)
                        <tr>
                            <td>{{ $slot->slotID }}</td>
                            <td>{{ $slot->slotNumber }}</td>
                            <td>{{ $slot->location }}</td>
                            <td>
                                <span class="badge bg-{{ $slot->status == 'Available' ? 'success' : 'danger' }}">
                                    {{ $slot->status }}
                                </span>
                            </td>
                            <td>${{ number_format($slot->pricePerHour, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.parking-slots.edit', $slot->slotID) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.parking-slots.destroy', $slot->slotID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this slot?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>