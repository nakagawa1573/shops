<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\genre;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'genre' => '寿司',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('genres')->insert($param);
        $param = [
            'genre' => '焼肉',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('genres')->insert($param);
        $param = [
            'genre' => '居酒屋',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('genres')->insert($param);
        $param = [
            'genre' => 'イタリアン',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('genres')->insert($param);
        $param = [
            'genre' => 'ラーメン',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('genres')->insert($param);
    }
}
