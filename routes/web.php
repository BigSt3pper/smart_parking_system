<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\SlotController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\ServiceRatingController;
use App\Http\Controllers\User\VehicleController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;



// MINIMAL TEST ROUTE
Route::get('/minimal-test', function() {
    return "Minimal test works!";
});

// =============================================
//              PUBLIC / DEFAULT ROUTES
// =============================================

// Homepage → user index
Route::get('/', [SlotController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

// =========================
// USER ROUTES (FRONTEND)
// =========================
// Parking slots (public)
Route::get('/slots', [SlotController::class, 'index'])->name('user.slots.index');
Route::get('/view-slots', [SlotController::class, 'index'])->name('view-slots');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Book slot (requires login)
    Route::get('/slots/{id}/book', [SlotController::class, 'bookForm'])->name('user.slots.book');
    Route::post('/slots/{id}/book', [SlotController::class, 'storeBooking'])->name('user.slots.book.store');

    // Reservations
    Route::get('/my-reservations', [ReservationController::class, 'index'])->name('user.reservations.index');
    Route::delete('/my-reservations/{id}', [ReservationController::class, 'destroy'])->name('user.reservations.cancel');

    // Payments
    Route::resource('payments', PaymentController::class)->except(['create', 'edit']);

    // Feedback
    Route::resource('feedback', FeedbackController::class)->except(['create', 'edit']);

    // Service Ratings
    Route::resource('ratings', ServiceRatingController::class)->except(['create', 'edit']);

    // Vehicles
    Route::resource('vehicles', VehicleController::class)->except(['create', 'edit']);

    // User management (if needed)
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});


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
    // Parking Slot Management
    Route::resource('parking-slots', App\Http\Controllers\Admin\ParkingSlotController::class);
    // Reservation Management
    Route::resource('reservations', App\Http\Controllers\Admin\ReservationController::class);
    // Reports
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');
    // Add other admin-only routes here
});