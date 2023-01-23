<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Http\Requests\Auth\ValidateEmailRequest;
use App\Models\User;
use DB;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;

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


        $user = User::where('email', $request->email)->first();

        $user->token = Str::random(60);

        $data = array(
            'token' =>  $user->token ,
            'email' =>  $user->email,
            'company' => Helper::getCompany()
        );

        
        Mail::send('auth.passwordReset', array ('data' => $data), function ($mail) use ( $user) {
            $mail->to($user->email)
                ->subject('User reset password');

        });



        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $user->token,
            'created_at' => now(),
        ]);

    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $token, $email)
    {
        return inertia('Auth/PasswordReset', ['token' => $token, 'email' => $email]);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(PasswordResetRequest $request)
    {
        DB::table('password_resets')->where('email', $request->email)->where('token', $request->token)->delete();

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);

        $user->save();

        Helper::login($user);
    }

}
