<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;
use App\Http\Controllers\BookingController;
use App\Http\Middleware\RoleMiddleware;
use Inertia\Inertia;

Route::get('/', [VillaController::class, 'index'])->name('home');
Route::get('/detail/{id}', [VillaController::class, 'show'])->name('villa.show');

Route::post('/book', [BookingController::class, 'store'])
    ->middleware(['auth:sanctum'])
    ->name('book.villa');

Route::get("/bookings/{user_id}", [BookingController::class, 'index'])
    ->middleware(['auth:sanctum'])
    ->name('booking.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RoleMiddleware::class
])->group(function () {

    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::prefix('villa')->name('villa.')->group(function () {
        Route::get('/', [VillaController::class, 'adminList'])->name('admin');
        Route::get('/create', [VillaController::class, 'create'])->name('create');
        Route::post('/', [VillaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [VillaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [VillaController::class, 'update'])->name('update');
        Route::delete('/{id}', [VillaController::class, 'destroy'])->name('delete');
    });
});
