<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\RegisterViewResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Show the registration view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\RegisterViewResponse
     */
    public function create(): RegisterViewResponse
    {
        return app(RegisterViewResponse::class);
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(CreateAccountRequest $request)
    {
        if (config('fortify.lowercase_usernames')) {
            $request->merge([
                Fortify::username() => Str::lower($request->{Fortify::username()}),
            ]);
        }
        $user = User::create($request->all());
        event(new Registered($user));
        $this->guard->login($user);
        return redirect('/register/verify');
    }

    public function showThanks()
    {
        Auth::guard('web')->logout();
        Auth::guard('owners')->logout();
        Auth::guard('admins')->logout();
        return view('thanks');
    }

    public function showVerify()
    {
        return view('auth.verifyEmail');
    }

    public function confirm(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect('/thanks');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '確認用メールを再送しました');
    }
}
