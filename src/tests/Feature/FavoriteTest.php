<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Shop;
use App\Models\Favorite;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function testFavoriteSuccess(): void
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $this->actingAs($user)->post('/favorite/'. $shop->id);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }

    public function testFavoriteNotLogin(): void
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $this->post('/favorite/' . $shop->id);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }

    public function testFavoriteDeleteSuccess(): void
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $favorite = Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
        $this->actingAs($user)->post('/favorite/'. $shop->id. '/delete');
        $this->assertDatabaseHas('favorites', [
            'id' => $favorite->id,
        ]);
    }

    public function testFavoriteDeleteNotLogin(): void
    {
        $user = User::factory()->create();
        $shop = Shop::inRandomOrder()->first();
        $favorite = Favorite::create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
        $this->post('/favorite/' . $shop->id . '/delete');
        $this->assertDatabaseHas('favorites', [
            'id' => $favorite->id,
        ]);
    }
}
