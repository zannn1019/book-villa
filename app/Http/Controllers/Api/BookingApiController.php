<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::with('villa')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'villa_id' => 'required|exists:villas,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $villa = Villa::findOrFail($data['villa_id']);
        $days = now()->parse($data['check_in'])->diffInDays($data['check_out']);

        if ($days < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum booking duration is 1 night.'
            ], 422);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'villa_id' => $villa->id,
            'check_in' => $data['check_in'],
            'check_out' => $data['check_out'],
            'total_price' => $days * $villa->price_per_night,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking successful!',
            'data' => $booking->load('villa')
        ], 201);
    }
}
