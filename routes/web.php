<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// MINIMAL TEST ROUTE - Add this at the very top
Route::get('/minimal-test', function() {
    return "Minimal test works!";
});

// =============================================
//              PUBLIC / DEFAULT ROUTES
// =============================================

// Redirect homepage to admin login page
Route::get('/', function () {
    return redirect('admin/login');
});

// Default Laravel user dashboard (for normal users)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =============================================
//           USER PROFILE MANAGEMENT
// =============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// =============================================
//          ADMIN AUTHENTICATION ROUTES 
// =============================================

// Public admin login routes
Route::get('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.submit');

// =============================================
//          PROTECTED ADMIN ROUTES 
// =============================================
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    
    // Admin dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Logout
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    
    // Parking Slot Management (Collo's part)
    Route::get('/parking-slots', [App\Http\Controllers\Admin\ParkingSlotController::class, 'index'])->name('admin.parking-slots.index');
    Route::get('/parking-slots/create', [App\Http\Controllers\Admin\ParkingSlotController::class, 'create'])->name('admin.parking-slots.create');
    Route::post('/parking-slots', [App\Http\Controllers\Admin\ParkingSlotController::class, 'store'])->name('admin.parking-slots.store');
    Route::get('/parking-slots/{id}/edit', [App\Http\Controllers\Admin\ParkingSlotController::class, 'edit'])->name('admin.parking-slots.edit');
    Route::put('/parking-slots/{id}', [App\Http\Controllers\Admin\ParkingSlotController::class, 'update'])->name('admin.parking-slots.update');
    Route::delete('/parking-slots/{id}', [App\Http\Controllers\Admin\ParkingSlotController::class, 'destroy'])->name('admin.parking-slots.destroy');
    
    // Reservation Management (Collo's part)
    Route::get('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/reservations/create', [App\Http\Controllers\Admin\ReservationController::class, 'create'])->name('admin.reservations.create');
    Route::post('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'store'])->name('admin.reservations.store');
    Route::get('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'show'])->name('admin.reservations.show');
    Route::get('/reservations/{reservation}/edit', [App\Http\Controllers\Admin\ReservationController::class, 'edit'])->name('admin.reservations.edit');
    Route::put('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'update'])->name('admin.reservations.update');
    Route::delete('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
    
    // Reports (Collo's part)
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');
    
    // Add other admin-only routes here
});