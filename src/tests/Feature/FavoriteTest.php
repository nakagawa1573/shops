<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavoriteTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     */
    public function testErrorShopIdNull(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/favorite', [
            'shop_id' => '',
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
        ]);
    }
}
