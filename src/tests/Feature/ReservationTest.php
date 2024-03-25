<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReservationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function testReservationCancel(): void
    {
        $user = User::factory()->create();
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
        $this->actingAs($user)->delete('/reservation/delete', [
            'id' => $reservation->id,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'user_id' => $user->id,
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
    }

    public function testReservationSuccess()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
        $response->assertStatus(302)
            ->assertRedirect('/done');
    }

    public function testReservationErrorNoLogin()
    {
        $user = User::factory()->create();
        $response = $this->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '22:00',
            'number' => 3,
        ]);
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function testReservationErrorDateNull()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => null,
            'time' => '22:00',
            'number' => 3,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => null,
            'time' => '22:00',
            'number' => 3,
        ]);
        $response->assertSessionHasErrors('date');
    }

    public function testReservationErrorDateDifferent()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => 'test',
            'time' => '22:00',
            'number' => 3,
        ]);
        $response->assertSessionHasErrors('date');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'time' => '22:00',
            'number' => 3,
        ]);
    }

    public function testReservationErrorTimeBefore()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '00:00',
            'number' => 3,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '00:00',
            'number' => 3,
        ]);
    }

    public function testReservationErrorTimeFormat()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:30:00',
            'number' => 3,
        ]);
        $response->assertSessionHasErrors('time');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:30:00',
            'number' => 3,
        ]);
    }

    public function testReservationErrorTimeDifferent()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => 'test',
            'number' => 3,
        ]);
        $response->assertSessionHasErrors('time');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'number' => 3,
        ]);
    }

    public function testReservationErrorTimeNull()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => null,
            'number' => 3,
        ]);
        $response->assertSessionHasErrors('time');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'number' => 3,
        ]);
    }

    public function testReservationErrorNumberDifferentNumeric()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => -1,
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => -1,
        ]);

        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => 10,
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => 10,
        ]);
    }

    public function testReservationErrorNumberDifferentString()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => 'test',
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => 'test',
        ]);
    }

    public function testReservationErrorNumberNull()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => null,
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => 1,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => null,
        ]);
    }

    public function testReservationErrorShopIdNull()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => null,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => 'over_10',
        ]);
        $response->assertSessionHasErrors('shop_id');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => null,
            'date' => now()->format('Y-m-d'),
            'time' => '23:00',
            'number' => 'over_10',
        ]);
    }

}
