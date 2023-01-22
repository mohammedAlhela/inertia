<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AccountCredentialsRequest;
use App\Http\Requests\Auth\AccountRequest;
use App\Models\Admin;
use App\Models\User;
use DB;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return inertia('App/Auth/Account', [
            'username' => auth()->user()->username,
            'user' => Admin::where('user_id', auth()->user()->id)->first(),
        ]);

    }

    public function update(AccountRequest $request)
    {

        auth()->user()->role == 'admin' || auth()->user()->role == 'super-admin' ? $role = 'admins' : 1 == 1;

        $image = request()->file("image");

        if ($request->roleKey == 'admin') {
            $user = Admin::where('user_id', auth()->user()->id);
        }

        // else if ($request->roleKey == 'teacher') {
        //     $user = Teacher::where('user_id', auth()->user()->id);
        // }

        // else if ($request->roleKey == 'student') {
        //     $user = Student::where('user_id', auth()->user()->id);
        // }

        // else {
        //     $user = Parent::where('user_id', auth()->user()->id);
        // }

        $user->update($request->except('image', 'created_at', 'updated_at', 'roleKey'));

        $data = array(
            "record" => $user->first(),
            "image" => $image,
            "dirPath" => "/images/$role/",
            "width" => 250,
            "height" => 250,

        );
        Helper::uploadImage($data);

    }

    public function updateCredentials(AccountCredentialsRequest $request)
    {

        $user = User::find(auth()->user()->id);

        $user->username = $request->username;
        
        $user->temp_credentials = 0;

        $request->updatePassword ? $user->password = Hash::make($request['password']) : 1 == 1;

        $user->save();

        $request->logoutFromSessions ? DB::table('sessions')->where('user_id', $user->id)->where('ip_address', '!=', $request->ip())->delete() : 1 == 1;
    }

}
