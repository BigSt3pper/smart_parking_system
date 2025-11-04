<?php
// TEMPORARY TEST ROUTES - Add at the top
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ParkingSlotController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ReportController;

// Test basic route
Route::get('/test', function () {
    return "✅ Test route working! Server is running on port 8000";
});

// Test database connection
Route::get('/test-db', function () {
    try {
        $slots = \App\Models\ParkingSlot::count();
        $users = \App\Models\User::count();
        return "✅ Database working! Parking Slots: $slots, Users: $users";
    } catch (\Exception $e) {
        return "❌ Database error: " . $e->getMessage();
    }
});

// Direct admin routes (bypass any prefix issues)
Route::get('/admin/parking-slots-direct', [ParkingSlotController::class, 'index']);
Route::get('/admin/reservations-direct', [ReservationController::class, 'index']);
Route::get('/admin/reports-direct', [ReportController::class, 'index']);

// ADMIN ROUTES
Route::get('/reports/export', [ReportController::class, 'export'])->name('admin.reports.export');
Route::prefix('admin')->group(function () {
    
    // PARKING SLOTS ROUTES
    Route::get('/parking-slots', [App\Http\Controllers\Admin\ParkingSlotController::class, 'index'])->name('admin.parking-slots.index');
    Route::get('/parking-slots/create', [App\Http\Controllers\Admin\ParkingSlotController::class, 'create'])->name('admin.parking-slots.create');
    Route::post('/parking-slots', [App\Http\Controllers\Admin\ParkingSlotController::class, 'store'])->name('admin.parking-slots.store');
    Route::get('/parking-slots/{parkingSlot}/edit', [App\Http\Controllers\Admin\ParkingSlotController::class, 'edit'])->name('admin.parking-slots.edit');
    Route::put('/parking-slots/{parkingSlot}', [App\Http\Controllers\Admin\ParkingSlotController::class, 'update'])->name('admin.parking-slots.update');
    Route::delete('/parking-slots/{parkingSlot}', [App\Http\Controllers\Admin\ParkingSlotController::class, 'destroy'])->name('admin.parking-slots.destroy');

    //  RESERVATIONS ROUTES 
    Route::get('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'index'])->name('admin.reservations.index');
    Route::get('/reservations/create', [App\Http\Controllers\Admin\ReservationController::class, 'create'])->name('admin.reservations.create');
    Route::post('/reservations', [App\Http\Controllers\Admin\ReservationController::class, 'store'])->name('admin.reservations.store');
    Route::get('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'show'])->name('admin.reservations.show');
    Route::get('/reservations/{reservation}/edit', [App\Http\Controllers\Admin\ReservationController::class, 'edit'])->name('admin.reservations.edit');
    Route::put('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'update'])->name('admin.reservations.update');
    Route::delete('/reservations/{reservation}', [App\Http\Controllers\Admin\ReservationController::class, 'destroy'])->name('admin.reservations.destroy');
    
    // REPORTS ROUTES
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'exports'])->name('admin.reports.exports');
    Route::get('/admin/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    
    
});