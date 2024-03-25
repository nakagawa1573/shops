<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names =[
            '仙人', '牛助', '戦慄', 'ルーク', '志摩屋',
            '香', 'JJ', 'らーめん極み', '鳥雨', '築地色合',
            '晴海', '三子', '八戒', '福助', 'ラー北',
            '翔', '経緯', '漆', 'THE TOOL', '木船',
        ];

        foreach ($names as $name) {
            $param = [
                'name' => $name,
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('123456789'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            DB::table('owners')->insert($param);
        }
        
        DB::table('owners')->insert([
            'name' => fake()->name(),
            'email' => 'owner@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
