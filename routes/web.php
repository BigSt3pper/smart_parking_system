<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Admin dashboard (new)
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Logout
    Route::post('/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');
    
    // Parking Slot Management (Collo’s part)
    Route::get('/parking-slots', [App\Http\Controllers\Admin\ParkingSlotController::class, 'index'])->name('admin.parking-slots.index');
    
    // Reservation Management (Collo’s part)
    Route::get('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('admin.reservations.index');
    
    // Reports (Collo’s part)
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    
    // Add other admin-only routes here
});
