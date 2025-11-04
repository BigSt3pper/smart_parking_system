@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
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

    <!-- Statistics Cards (matches Collo's styling) -->
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
        <!-- Add other stat cards following same pattern -->
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
@endsection
