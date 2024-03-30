<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'user_id' => 1,
            'shop_id' => 1,
            'product_id' => 1,
            'date' => now()->addDay(),
            'time' => '12:30',
            'number' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => 1,
            'shop_id' => 2,
            'product_id' => 1,
            'date' => now()->addDay(),
            'time' => '12:30',
            'number' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => 1,
            'shop_id' => 3,
            'product_id' => 1,
            'date' => now()->addDay(),
            'time' => '12:30',
            'number' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('reservations')->insert($param);

        Reservation::factory()->count(30)->create();
    }
}
