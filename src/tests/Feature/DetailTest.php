<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DetailTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function testMoveDetail()
    {
        $shop = Shop::inRandomOrder()->first();
        $response = $this->get(route('detail', [
            'shop_id' => $shop->id,
            'id' => $shop->id,
        ]));
        $response->assertStatus(200);
        $response->assertViewIs('detail');
        $response->assertSee($shop->shop);
    }

    public function testBackCaseIndex()
    {
        $this->get('/')->assertStatus(200);

        $shop = Shop::inRandomOrder()->first();
        $this->get(route('detail', [
            'shop_id' => $shop->id,
            'id' => $shop->id,
        ]));
        $response = $this->followingRedirects()->get('/back');
        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    public function testBackCaseMypage()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/mypage')->assertStatus(200);

        $shop = Shop::inRandomOrder()->first();
        $this->actingAs($user)->get(route('detail', [
            'shop_id' => $shop->id,
            'id' => $shop->id,
        ]));
        $response = $this->followingRedirects()->get('/back');
        $response->assertStatus(200);
        $response->assertViewIs('mypage');
    }
}
