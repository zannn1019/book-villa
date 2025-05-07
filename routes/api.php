<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VillaApiController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\BookingApiController;

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    return $user->createToken('api-token')->plainTextToken;
});

Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken('api-token')->plainTextToken;
});

Route::post('/logout', function (Request $request) {
    $request->user()->tokens()->delete();
    return response()->json(['message' => 'Logged out']);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/villas', [VillaApiController::class, 'index']);
Route::get('/villas/{id}', [VillaApiController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/villas', [VillaApiController::class, 'store']);
    Route::put('/villas/{id}', [VillaApiController::class, 'update']);
    Route::delete('/villas/{id}', [VillaApiController::class, 'destroy']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/bookings', [BookingApiController::class, 'index']);
    Route::post('/bookings', [BookingApiController::class, 'store']);
    Route::get('/bookings/{id}', [BookingApiController::class, 'show']);
    Route::put('/bookings/{id}', [BookingApiController::class, 'update']);
    Route::delete('/bookings/{id}', [BookingApiController::class, 'destroy']);
});
