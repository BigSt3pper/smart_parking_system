<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2>Reservations Management</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">
                    + Create Reservation
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Reservation ID</th>
                                <th>User</th>
                                <th>Slot</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Total Cost</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                            <tr>
                                <td>#{{ $reservation->reservationID }}</td>
                                <td>{{ $reservation->user->fullName ?? 'N/A' }}</td>
                                <td>{{ $reservation->parkingSlot->slotNumber ?? 'N/A' }}</td>
                                <td>{{ $reservation->startTime->format('M d, Y H:i') }}</td>
                                <td>{{ $reservation->endTime->format('M d, Y H:i') }}</td>
                                <td>${{ number_format($reservation->totalCost, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $reservation->reservationStatus == 'Active' ? 'success' : 
                                        ($reservation->reservationStatus == 'Completed' ? 'info' : 'danger') 
                                    }}">
                                        {{ $reservation->reservationStatus }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $reservation->paymentStatus == 'Paid' ? 'success' : 
                                        ($reservation->paymentStatus == 'Pending' ? 'warning' : 'danger') 
                                    }}">
                                        {{ $reservation->paymentStatus }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.reservations.show', $reservation->reservationID) }}" 
                                       class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('admin.reservations.edit', $reservation->reservationID) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.reservations.destroy', $reservation->reservationID) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Delete this reservation?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No reservations found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>