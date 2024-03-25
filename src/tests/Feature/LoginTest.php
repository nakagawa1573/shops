<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginSuccess(): void
    {
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
        $response =$this->post('/login', [
            'email' => 'test@test.com',
            'password' => '123456789',
        ]);
        $response->assertRedirect('/')->assertStatus(302);
    }

    public function testLoginErrorEmailNull()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
        $response = $this->post('/login', [
            'email' => null,
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testLoginErrorEmailDifferent()
    {
        $this->assertDatabaseMissing('users', [
            'email' => 'test@tesst.com',
        ]);
        $response = $this->post('/login', [
            'email' => 'test@tesst.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testLoginErrorPasswordNull()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => null,
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function testLoginErrorPasswordDifferent()
    {
        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
        ]);
        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '213456789',
        ]);
        $response->assertSessionHasErrors();
    }
}
