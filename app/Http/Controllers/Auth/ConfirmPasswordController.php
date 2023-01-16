<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfirmPasswordController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showConfirmForm()
    {
        return Inertia::render("Auth/PasswordConfirm");
    }

    public function confirmPassword(Request $request)
    {
        $request->validate(['password' => 'required|current_password:web']);

        $request->session()->put('auth.password_confirmed_at', time());

        return $request->wantsJson()
        ? new JsonResponse([], 204)
        : redirect()->intended('/');
    }
}
