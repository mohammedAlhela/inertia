<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserPasswordRequest;
use App\Http\Requests\Users\Admins\AdminRequest;

use Illuminate\Http\Request;
use App\Mail\Auth\UserPasswordMail;
use App\Models\User;
use DB;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use Image;

class AdminController extends Controller
{

    public function index()
    {

        return inertia('App/Users/Index', [
            'admins' => User::with('permissions')->where('id', '!=', auth()->user()->id)->whereIn('role', ['admin', 'super-admin'])->get(),
        ]);

    }

    public function create()
    {
        return inertia('App/Users/Create');
    }

    public function store($AdminRequest)
    {

    $image = request()->file("image");

    $user = User::create($request->except('image', 'created_at', 'updated_at'));

    $data = array(
        "record" => $user,
        "image" => $image,
        "dirPath" => "/images/users/",
        "width" => 250,
        "height" => 250,

    );
    Helper::uploadImage($data); 
    }







    // public function create()
    // {

    //     $user = new User;
    //     $user->username = "Jackichan";
    //     $user->email = "jackij290@gmail.com";
    //     $user->name = "Jackichan";
    //     $user->role = "admin";
    //     $user->mobile = "9898989898";
    //     $user->save();

    //     $user->token = Str::random(60);

    //     Mail::to($user)->send(new UserPasswordMail($user));

    //     DB::table('user_password')->insert([
    //         'id' => 10,
    //         'email' => $user->email,
    //         'token' => $user->token,
    //         'created_at' => now(),

    //     ]);

    // }

    public function showSetPassword($token, $email)
    {

        return inertia('Auth/UserPassword', ['token' => $token, 'email' => $email]);

    }

    public function updatePassword(UserPasswordRequest $request)
    {

        DB::table('user_password')->where('email', $request->email)->where('token', $request->token)->delete();

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->password);

        $user->save();

        Helper::login($request);

    }

}
