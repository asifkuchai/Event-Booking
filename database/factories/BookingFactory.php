<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition()
    {
        return [
            'user_id'  => User::factory(),
            'event_id' => Event::factory(),
            'tickets'  => $this->faker->numberBetween(1, 5),
        ];
    }
}
