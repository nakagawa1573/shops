<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'user_id' => 1,
            'shop_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('favorites')->insert($param);

        $param = [
            'user_id' => 1,
            'shop_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('favorites')->insert($param);

        $param = [
            'user_id' => 1,
            'shop_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('favorites')->insert($param);
    }
}
