<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'title'       => $this->faker->sentence(3),
            'event_date'        => $this->faker->dateTimeBetween('+1 days', '+1 month'),
            'capacity'    => $this->faker->numberBetween(10, 100),
            'venue' => $this->faker->city,

        ];
    }
}
