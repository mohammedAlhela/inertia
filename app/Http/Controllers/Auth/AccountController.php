<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AccountRequest;
use App\Http\Requests\Auth\AccountPasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Helper;
use DB;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return inertia('Auth/Account', [
            'user' => auth()->user(),
        ]);

    }

    public function update(AccountRequest $request)
    {

        $image = request()->file("image");

        $user = User::where('id', 1)->update($request->except('image', 'created_at', 'updated_at'));

        $user = User::find(1);

        $data = array(
            "record" => $user,
            "image" => $image,
            "dirPath" => "/images/users/",
            "width" => 250,
            "height" => 250,

        );
        Helper::uploadImage($data);

    }

    public function updatePassword(AccountPasswordRequest $request)
    {
    $user = auth()->user();
    $user->password = Hash::make($request['password']);
    $user->save();

    if($request->logoutFromSessions) {
      DB::table('sessions')->where('user_id' , $user->id )->where('ip_address' , '!=' , $request->ip())->delete();
    }
    }

}
