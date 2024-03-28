<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Shop;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReservationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function testReservationCancelSuccess(): void
    {
        $user = User::factory()->create();
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0,23)).':'. $minutes[array_rand($minutes)];
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $numbersArray = [rand(1,9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $this->actingAs($user)->delete('/reservation/delete/'.$reservation->id);
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
    }

    public function testReservationCancelErrorPolicy(): void
    {
        $user = User::factory()->create();
        $RandomReservation = Reservation::inRandomOrder()->first();
        $response = $this->actingAs($user)->delete('/reservation/delete/'. $RandomReservation->id);
        $response->assertStatus(403);
        $this->assertDatabaseHas('reservations', [
            'id' => $RandomReservation->id,
        ]);
    }

    public function testReservationSuccess()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $minutes = ['00', '30'];
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/'. $shop->id, [
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $response->assertStatus(302)
            ->assertRedirect('/done');
    }

    public function testReservationErrorNoLogin()
    {
        $shop = Shop::inRandomOrder()->first();
        $minutes = ['00', '30'];
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->post('/reservation/'. $shop->id, [
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $response->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function testReservationErrorDateNull()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => null,
            'time' => $time,
            'number' => $number,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => null,
            'time' => $time,
            'number' => $number,
        ]);
        $response->assertSessionHasErrors('date');
    }

    public function testReservationErrorDateDifferent()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $minutes = ['00', '30'];
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => 'test',
            'time' => $time,
            'number' => $number,
        ]);
        $response->assertSessionHasErrors('date');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'time' => $time,
            'number' => $number,
        ]);
    }

    public function testReservationErrorTimeBefore()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => now()->format('Y-m-d'),
            'time' => '00:00',
            'number' => $number,
        ]);
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => now()->format('Y-m-d'),
            'time' => '00:00',
            'number' => $number,
        ]);
    }

    public function testReservationErrorTimeFormat()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)] . sprintf("%02d", rand(0, 59));
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
        $response->assertSessionHasErrors('time');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
    }

    public function testReservationErrorTimeDifferent()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => $date,
            'time' => 'test',
            'number' => $number,
        ]);
        $response->assertSessionHasErrors('time');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => 'test',
            'number' => $number,
        ]);
    }

    public function testReservationErrorTimeNull()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => $date,
            'time' => null,
            'number' => $number,
        ]);
        $response->assertSessionHasErrors('time');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => null,
            'number' => $number,
        ]);
    }

    public function testReservationErrorNumberDifferentNumeric()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => $date,
            'time' => $time,
            'number' => -1,
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => -1,
        ]);

        $response = $this->actingAs($user)->post('/reservation', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => 10,
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => 10,
        ]);
    }

    public function testReservationErrorNumberDifferentString()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => $date,
            'time' => $time,
            'number' => 'test',
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => 'test',
        ]);
    }

    public function testReservationErrorNumberNull()
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $response = $this->actingAs($user)->post('/reservation/' . $shop->id, [
            'date' => $date,
            'time' => $time,
            'number' => null,
        ]);
        $response->assertSessionHasErrors('number');
        $this->assertDatabaseMissing('reservations', [
            'shop_id' => $shop->id,
            'date' => $date,
            'time' => $time,
            'number' => null,
        ]);
    }

    public function testReservationMoveUpdatePageErrorPolicy()
    {
        $user = User::factory()->create();
        $reservation = Reservation::inRandomOrder()->first();
        $response = $this->actingAs($user)->get('/reservation/update/'. $reservation->id);
        $response->assertStatus(403);
    }

    public function testReservationUpdateSuccess()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $this->actingAs($user)
            ->patch('/reservation/update/'.$reservation->id, [
                'date' => $date,
                'time' => $time,
                'number' => $number,
            ]);
        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'user_id' => $user->id,
            'date' => $date,
            'time' => $time,
            'number' => $number,
        ]);
    }

    public function testReservationErrorPolicyCreate()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', '!=', $user->id)->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $response = $this->actingAs($user)
            ->patch('/reservation/update/'.$reservation->id, [
                'date' => $date,
                'time' => $time,
                'number' => $number,
            ]);
        $response->assertStatus(403);
    }

    public function testReservationUpdateErrorAllNull()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $request = $this->actingAs($user)
            ->patch('/reservation/update/'. $reservation->id, [
                'date' => null,
                'time' => null,
                'number' => null,
            ]);
        $request->assertSessionHasErrors(['date', 'time', 'number']);
    }

    public function testReservationUpdateErrorBeforeDate()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $request = $this->actingAs($user)
            ->patch('/reservation/update/'. $reservation->id, [
                'date' => now()->subDay()->format('Y-m-d'),
                'time' => $time,
                'number' => $number,
            ]);
        $request->assertSessionHasErrors('date');
    }

    public function testReservationUpdateErrorDateType()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $request = $this->actingAs($user)
            ->patch('/reservation/update/' . $reservation->id, [
                'date' => 'test',
                'time' => $time,
                'number' => $number,
            ]);
        $request->assertSessionHasErrors('date');
    }

    public function testReservationUpdateErrorTimeType()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $request = $this->actingAs($user)
            ->patch('/reservation/update/'. $reservation->id, [
                'date' => $date,
                'time' => 'test',
                'number' => $number,
            ]);
        $request->assertSessionHasErrors('time');
    }

    public function testReservationUpdateErrorTimeFormat()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)] . sprintf("%02d", rand(0, 59));
        $numbersArray = [rand(1, 9), 'over_10'];
        $number = $numbersArray[array_rand($numbersArray)];
        $request = $this->actingAs($user)
            ->patch('/reservation/update/'.$reservation->id, [
                'date' => $date,
                'time' => $time,
                'number' => $number,
            ]);
        $request->assertSessionHasErrors('time');
    }

    public function testReservationUpdateErrorNumberOver()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $request = $this->actingAs($user)
            ->patch('/reservation/update/'. $reservation->id, [
                'date' => $date,
                'time' => $time,
                'number' => '10',
            ]);
        $request->assertSessionHasErrors('number');
    }

    public function testReservationUpdateErrorNumberString()
    {
        $user = User::find(1);
        $reservation = Reservation::where('user_id', $user->id)->first();
        $date = fake()->dateTimeBetween($startDate = '+1 day', $endDate = '+1 year')->format('Y-m-d');
        $minutes = ['00', '30'];
        $time = sprintf("%02d", rand(0, 23)) . ':' . $minutes[array_rand($minutes)];
        $request = $this->actingAs($user)
            ->patch('/reservation/update/'. $reservation->id, [
                'date' => $date,
                'time' => $time,
                'number' => 'test',
            ]);
        $request->assertSessionHasErrors('number');
    }
}
