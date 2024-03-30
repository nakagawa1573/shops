<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;

class MenuTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * A basic feature test example.
     */
    public function testMoveHome(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    public function testMoveRegistration(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    public function testMoveLogin(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function testStatusLoginMoveHome(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    public function testStatusLoginPostLogout(): void
    {
        $user = User::factory()->create();
        $response = $this->followingRedirects()->actingAs($user)->post('/logout');

        $response->assertStatus(200);
        $response->assertViewIs('index');
    }

    public function testStatusLoginMoveMypage(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertViewIs('mypage');
        $response->assertSee($user->name);
    }
}
