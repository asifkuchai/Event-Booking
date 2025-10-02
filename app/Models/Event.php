<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'venue', 'capacity', 'event_date'];

    // Cast event_date to datetime
    protected $casts = [
        'event_date' => 'datetime',
    ];

    // Add this function
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }
}

