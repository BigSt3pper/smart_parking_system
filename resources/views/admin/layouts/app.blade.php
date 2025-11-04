
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParkSmart Admin - @yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .admin-sidebar {
            background: var(--primary-color);
            min-height: 100vh;
            color: white;
            position: fixed;
            width: 250px;
        }
        
        .admin-content {
            margin-left: 250px;
            padding: 20px;
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid #34495e;
            text-align: center;
        }
        
        .sidebar-nav .nav-link {
            color: #bdc3c7;
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }
        
        .sidebar-nav .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: var(--accent-color);
        }
        
        .sidebar-nav .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left-color: var(--accent-color);
        }
        
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-left: 250px;
        }
        
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .card-custom:hover {
            transform: translateY(-2px);
        }
        
        .stat-card {
            border-left: 4px solid var(--accent-color);
        }
        
        .table-custom {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-primary-custom {
            background: var(--accent-color);
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
        }
        
        .btn-primary-custom:hover {
            background: #2980b9;
        }
        
        .badge-custom {
            border-radius: 12px;
            padding: 6px 12px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-brand">
            <h4 class="mb-0">🅿️ ParkSmart</h4>
            <small class="text-muted">Admin Panel</small>
        </div>
        
        <nav class="sidebar-nav mt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/parking-slots*') ? 'active' : '' }}" 
                       href="{{ route('admin.parking-slots.index') }}">
                        <i class="bi bi-p-square me-2"></i> Parking Slots
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/reservations*') ? 'active' : '' }}" 
                       href="{{ route('admin.reservations.index') }}">
                        <i class="bi bi-calendar-check me-2"></i> Reservations
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.index') }}">
                        <i class="bi bi-graph-up me-2"></i> Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-people me-2"></i> Users
                    </a>
                </li>
                <li class="nav-item mt-4">
    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="nav-link text-warning border-0 bg-transparent w-100 text-start">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
</li>
                
                
                
                
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="admin-content">
        <!-- Top Navigation -->
        <nav class="navbar navbar-custom mb-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h6">
                    <i class="bi bi-house me-2"></i> @yield('title', 'Dashboard')
                </span>
                <div class="d-flex">
                    <span class="navbar-text me-3">
                        <i class="bi bi-person-circle me-1"></i> Admin User
                    </span>
                    <span class="badge bg-success">Online</span>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>
