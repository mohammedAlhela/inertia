<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EmailVerificationController extends Controller
{


    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only(['verify']);
    }


    public function create()
    {
        return Inertia::render('App/Auth/EmailVerification');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/');

    }

}
