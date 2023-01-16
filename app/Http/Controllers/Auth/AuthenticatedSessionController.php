<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Helper;
use Inertia\Inertia;

class AuthenticatedSessionController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->only(['create','store']);
        $this->middleware('auth')->only(['verify' , 'accountShow' , 'accountWrite']);
    }

    /**
     * Display the login view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }


    public function accountShow()
    {
        return Inertia::render('Auth/Account' , [
            'user' => auth()->user()
        ]);

    }


    public function accountWrite(Request $request)
    {

        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email| max:255|unique:users,email,' . auth()->user()->id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image',
        ]);

        $image = $request->file('image');

        $user = User::find(auth()->user()->id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $request->password ? $user->password = Hash::make($request['password']) : $nullExist = null;
        $data = array(
            "record" => $user,
            "image" => $image,
            "dirPath" => "/images/users/",
            "width" => 600,
            "height" => 600,

        );
        Helper::uploadImage($data);
    }


    
}
