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
                <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>