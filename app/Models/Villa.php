<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Villa extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price_per_night',
        'location',
        'capacity',
        'image',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
