<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Admin;

class CreateOwnerTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testCreateOwnerSuccess(): void
    {
        $admin = Admin::find(1)->first();
        $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => '山田太郎',
            'email' => 'ownerr@test.com',
            'password' => '123456789',
        ]);
        $this->assertDatabaseHas('owners', [
            'name' => '山田太郎',
            'email' => 'ownerr@test.com',
        ]);
    }

    public function testCreateOwnerErrorNotLogin()
    {
        $admin = Admin::find(1)->first();
        $response = $this->post('/admin', [
            'name' => '山田太郎',
            'email' => 'ownerr@test.com',
            'password' => '123456789',
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('owners', [
            'name' => '山田太郎',
            'email' => 'ownerr@test.com',
        ]);
    }

    public function testCreateOwnerErrorAllNull()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => null,
            'email' => null,
            'password' => null,
        ]);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function testCreateOwnerErrorAllType()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => ['name' => '山田太郎'],
            'email' => ['email' => 'ownerr@test.com'],
            'password' => ['password' => '123456789'],
        ]);
        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function testCreateOwnerErrorNameEmailMax()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => '山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎山田太郎',
            'email' => 'ownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerrownerr@test.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function testCreateOwnerErrorPasswordMin()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => '山田太郎',
            'email' => 'ownerr@test.com',
            'password' => '1234567',
        ]);
        $response->assertSessionHasErrors('password');
    }

    public function testCreateOwnerErrorEmailType()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => '山田太郎',
            'email' => 'ownerrtest.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }


    public function testCreateOwnerErrorEmailDns()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => '山田太郎',
            'email' => 'ownerr@testaaaaaaaaaaaa.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }

    public function testCreateOwnerErrorEmailSame()
    {
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin', [
            'name' => '山田太郎',
            'email' => 'owner@test.com',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors('email');
    }
}
