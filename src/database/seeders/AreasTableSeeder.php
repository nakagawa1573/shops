<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Area;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'area' => '東京都',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('areas')->insert($param);
        $param = [
            'area' => '大阪府',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('areas')->insert($param);
        $param = [
            'area' => '福岡県',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('areas')->insert($param);
    }
}
