<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Models\User;
use App\Mail\NotificationEmail;

class EmailTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testEmailSendSuccess(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => 'test',
            'content' => 'testtesttest',
        ]);
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

    public function testEmailSendErrorNotLogin(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $response = $this->post('/admin/mail', [
            'subject' => 'test',
            'content' => 'testtesttest',
        ]);
        $response->assertRedirect('/login');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

    public function testEmailSendErrorSubjectNull(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => null,
            'content' => 'testtesttest',
        ]);
        $response->assertSessionHasErrors('subject');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

    public function testEmailSendErrorSubjectString(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => ['subject' => 'test'],
            'content' => 'testtesttest',
        ]);
        $response->assertSessionHasErrors('subject');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }
    public function testEmailSendErrorSubjectMax(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
            'content' => 'testtesttest',
        ]);
        $response->assertSessionHasErrors('subject');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

    public function testEmailSendErrorContentNull(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => 'test',
            'content' => null,
        ]);
        $response->assertSessionHasErrors('content');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

    public function testEmailSendErrorContentString(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => 'test',
            'content' => ['content' => 'testtest'],
        ]);
        $response->assertSessionHasErrors('content');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

    public function testEmailSendErrorContentMax(): void
    {
        Mail::fake();
        Mail::assertNothingSent();
        $admin = Admin::find(1)->first();
        $response = $this->actingAs($admin, 'admins')->post('/admin/mail', [
            'subject' => 'test',
            'content' => 'testtesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttesttest',
        ]);
        $response->assertSessionHasErrors('content');
        $users = User::all();
        foreach ($users as $user) {
            Mail::assertNothingSent(NotificationEmail::class, function ($mail) use ($user) {
                return $mail->hasTo($user);
            });
        }
    }

}
