<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Smart Parking System</title>
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
            display: block;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">
                <i class="bi bi-speedometer2 me-2"></i> Admin Dashboard
            </h2>
            <div class="d-flex align-items-center">
                <span class="me-3">Welcome, {{ Auth::user()->fullName }}</span>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title text-muted">Total Users</h6>
                                <h3 class="mb-0">{{ $stats['totalUsers'] }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-people display-6 text-primary"></i>
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
                                <h6 class="card-title text-muted">Total Parking Slots</h6>
                                <h3 class="mb-0">{{ $stats['totalSlots'] }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-p-square display-6 text-success"></i>
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
                                <h6 class="card-title text-muted">Active Reservations</h6>
                                <h3 class="mb-0">{{ $stats['activeReservations'] }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-calendar-check display-6 text-warning"></i>
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
                                <h6 class="card-title text-muted">Available Slots</h6>
                                <h3 class="mb-0">{{ $stats['availableSlots'] }}</h3>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-p-circle display-6 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('admin.parking-slots.index') }}" class="btn btn-primary-custom w-100">
                                    <i class="bi bi-p-square me-2"></i>Manage Parking Slots
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reservations.index') }}" class="btn btn-success w-100">
                                    <i class="bi bi-calendar-check me-2"></i>View Reservations
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reports.index') }}" class="btn btn-info w-100">
                                    <i class="bi bi-graph-up me-2"></i>Reports & Analytics
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>