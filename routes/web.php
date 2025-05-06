<?php

use App\Http\Controllers\BookingController;
use Inertia\Inertia;
use App\Models\Villa;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VillaController;
use App\Http\Middleware\RoleMiddleware;


Route::get('/', [VillaController::class, 'index'])->name('home');
Route::get('/detail/{id}', [VillaController::class, 'show'])->name('villa.show');

Route::post('/book', [BookingController::class, 'store'])->name('book.villa')->middleware(['auth:sanctum']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    RoleMiddleware::class
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
