<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Event;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_book_event_successfully()
    {
        Mail::fake();

        $event = Event::factory()->create(['capacity' => 10]);
        $user = User::factory()->create(); // ✅ This returns a single User model

        /** @var \App\Models\User $user */
        $response = $this->actingAs($user)->post(route('bookings.store'), [
            'event_id' => $event->id,
            'tickets' => 2,
        ]);

        $response->assertRedirect(route('bookings.index'))
                 ->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'tickets' => 2,
        ]);

        Mail::assertQueued(BookingConfirmation::class);
    }

    public function test_user_cannot_book_when_event_is_full()
    {
        $event = Event::factory()->create(['capacity' => 5]);

        Booking::factory()->create([
            'event_id' => $event->id,
            'tickets' => 5,
        ]);

        /** @var \App\Models\User $user */
        $user = User::factory()->create(); // ✅ Single user

        $response = $this->actingAs($user)->post(route('bookings.store'), [
            'event_id' => $event->id,
            'tickets' => 1,
        ]);

        $response->assertSessionHasErrors('tickets');
    }
}
