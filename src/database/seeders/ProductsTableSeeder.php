<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
            'shop_id' => 1,
            'product' => 'price_1OwamAIAfOPo2c24h4qyQtXm',
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('products')->insert($param);
    }
}
