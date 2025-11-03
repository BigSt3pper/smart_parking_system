<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use Illuminate\Support\Facades\Route;

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