<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testReservation(): void
    {
        $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@tesst.com',
            'password' => '123456789',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => '山田太郎',
            'email' => 'test@tesst.com',
        ]);
    }

    public function testReservationErrorAllNull(): void
    {
        $response = $this->post('/register', [
            'name' => null,
            'email' => null,
            'password' => null,
        ]);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function testReservationErrorNameString(): void
    {
        $response = $this->post('/register', [
            'name' => ['name' => '山田太郎'],
            'email' => 'test@tesst.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', [
            'email' => 'test@tesst.com',
        ]);
    }

    public function testReservationErrorNameMax(): void
    {
        $response = $this->post('/register', [
            'name' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
            'email' => 'test@tesst.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('users', [
            'name' => 'テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト',
            'email' => 'test@tesst.com',
        ]);
    }

    public function testReservationErrorEmailDifferent(): void
    {
        $response = $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'test',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => '山田太郎',
            'email' => 'test',
        ]);
    }

    public function testReservationErrorEmailDns(): void
    {
        $response = $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@aaaaaaaaa.aa',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', [
            'name' => '山田太郎',
            'email' => 'test@aaaaaaaaa.aa',
        ]);
    }

    public function testReservationErrorEmailDejaVu(): void
    {
        $this->assertDatabaseHas('users', [
            'name' => '山田太郎',
            'email' => 'test@test.com',
        ]);

        $response = $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@test.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testReservationErrorPasswordDifferent(): void
    {
        $response = $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@tesst.com',
            'password' => ['password' => '123456789'],
        ]);
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', [
            'name' => '山田太郎',
            'email' => 'test@tesst.com',
        ]);
    }

    public function testReservationErrorPasswordMin(): void
    {
        $response = $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@tesst.com',
            'password' => '1234567',
        ]);
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', [
            'name' => '山田太郎',
            'email' => 'test@tesst.com',
        ]);
    }
}
