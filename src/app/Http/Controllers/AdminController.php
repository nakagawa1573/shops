<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateAccountRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;
use App\Models\User;
use App\Http\Requests\EmailRequest;
use Illuminate\Auth\Events\Registered;

class AdminController extends Controller
{
    public function index()
    {
        return view('auth.admin');
    }

    public function store(CreateAccountRequest $request)
    {
        $owner = $request->only(['name', 'email']);
        $owner['password'] = Hash::make($request->password);
        $user = Owner::create($owner);
        event(new Registered($user));
        return redirect('/admin')->with('message', 'アカウントを作成しました');
    }

    public function showMail()
    {
        return view('mail');
    }

    public function send(EmailRequest $request){
        $subject = $request->input('subject');
        $content = $request->input('content');
        $addresses = User::all();
        foreach ($addresses as $address) {
            Mail::to($address)->send(new NotificationEmail($subject, $content));
        }

        return redirect('/admin/mail')->with('message', 'メールを送信しました');
    }
}
