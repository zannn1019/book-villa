<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Villa;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'villa_id' => 'required|exists:villas,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $villa = Villa::findOrFail($data['villa_id']);
        $days = now()->parse($data['check_in'])->diffInDays($data['check_out']);

        $data['total_price'] = $days * $villa->price_per_night;
        $data['user_id'] = auth()->user()->id;

        Booking::create($data);

        return back()->with('success', 'Booking successful!');
    }

    public function index($user_id)
    {
        $bookings = Booking::where('user_id', $user_id)->with('villa')->get();

        return Inertia::render('Bookings/index', [
            'bookings' => $bookings,
        ]);
    }
}
