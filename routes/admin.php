<?php

//use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ParkingSlotController;
//use App\Http\Controllers\Admin\UserController;
//use App\Http\Controllers\Admin\ReportController;
//use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [AuthController::class, 'login']);

// Protected Admin Routes (require admin authentication)
Route::middleware(['auth:admin'])->group(function () {
    
    //Dashboard
    //Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    //Parking Slots Mangaement
    Route::resource('parking-slots', ParkingSlotController::class);

    //Reservation Management
    Route::resource('reservations', ReservationController::class);

    //User Management
   // Route::resource('users', UserController::class);

    //Reports
    //Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    //Route::get('/reports/export', [ReportsController::class, 'export'])->name('reports.export');

    //Logout
    //Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});