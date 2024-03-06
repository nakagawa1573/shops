<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Reservation;

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
            'date' => '2024-03-10',
            'time' => '12:30',
            'number' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => 1,
            'shop_id' => 2,
            'date' => '2024-03-11',
            'time' => '12:30',
            'number' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => 1,
            'shop_id' => 3,
            'date' => '2024-03-12',
            'time' => '12:30',
            'number' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('reservations')->insert($param);
    }
}
