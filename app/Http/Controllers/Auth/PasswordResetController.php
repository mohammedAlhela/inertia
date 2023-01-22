<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\Auth\PasswordResetRequest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidateEmailRequest;
use App\Mail\Auth\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Admin;
use App\Models\User;
use Mail;
use Helper;
use DB;

class PasswordResetController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return inertia('Auth/PasswordEmail');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ValidateEmailRequest $request)
    {

        $user = Admin::with('user')->where('email', $request->email)->first()->user();

        $user->token = Str::random(60);

        $user->email = $request->email;

        Mail::to($user)->send(new PasswordResetMail($user));

        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $user->token,
            'created_at' => now()
        ]);

    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $token , $email)
    {
        return inertia('Auth/PasswordReset', ['token' => $token , 'email' => $email]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(PasswordResetRequest $request)
    {
        DB::table('password_resets')->where('email', $request->email)->where('token', $request->token)->delete();

        $user_id = Admin::with('user')->where('email', $request->email)->first()->user->id;

        $user = User::find($user_id);

        $user->password = Hash::make($request->password);

        $user->save();

        $request->username  = $user->username;

        Helper::login($request);
    }

}
