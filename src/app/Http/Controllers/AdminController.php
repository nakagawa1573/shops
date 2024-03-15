<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateOwnerRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;
use App\Models\User;
use Endroid\QrCode\QrCode;

class AdminController extends Controller
{
    public function index()
    {
        $qrCode = new QrCode('こんにちは、QRコード');
        return view('auth.admin');
    }

    public function create()
    {
        if (Auth::guard('admins')->user()) {
            return redirect('/admin');
        }

        return view('auth.adminLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admins')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        } else {
            return back()->withErrors([
                'error' => 'ログインに失敗しました'
            ]);
        }
    }

    public function logout()
    {
        Auth::guard('admins')->logout();
        return redirect('/admin/login');
    }

    public function store(CreateOwnerRequest $request)
    {
        $owner = $request->only(['name', 'email']);
        $owner['password'] = Hash::make($request->password);
        Owner::create($owner);
        return redirect('/admin')->with('message', 'アカウントを作成しました');
    }

    public function showMail()
    {
        return view('mail');
    }

    public function send(Request $request){
        $subject = $request->input('subject');
        $content = $request->input('content');
        $addresses = User::all();
        foreach ($addresses as $address) {
            Mail::to($address)->send(new NotificationEmail($subject, $content));
        }

        return redirect('/admin/mail')->with('message', 'メールを送信しました');
    }
}
