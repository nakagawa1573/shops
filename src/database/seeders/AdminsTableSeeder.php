<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('123456789'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('admins')->insert($param);
    }
}
