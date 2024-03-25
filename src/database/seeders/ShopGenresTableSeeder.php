<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopGenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'shop_id' => 1,
            'genre_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 2,
            'genre_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 3,
            'genre_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 4,
            'genre_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 5,
            'genre_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 6,
            'genre_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 7,
            'genre_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 8,
            'genre_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 9,
            'genre_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 10,
            'genre_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 11,
            'genre_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 12,
            'genre_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 13,
            'genre_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 14,
            'genre_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 15,
            'genre_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 16,
            'genre_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 17,
            'genre_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 18,
            'genre_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 19,
            'genre_id' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
        $param = [
            'shop_id' => 20,
            'genre_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shop_genres')->insert($param);
    }
}
