<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(OwnersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(GenresTableSeeder::class);
        $this->call(ShopsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ShopGenresTableSeeder::class);
        $this->call(FavoritesTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
        $this->call(EvaluationsTableSeeder::class);
    }
}
