<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Http\Requests\UserRequest;
use App\Models\Permission;
use App\Models\User;
use Excel;
use Hash;
use Helper;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');

    }

    public function index()
    {

        $authArray = array('user', 'show');

        Helper::authorizeModel($authArray);

        return inertia('Users/Index', [
            'users' => User::where('id', '!=', auth()->user()->id)->with('permissions')->orderBy('created_at', 'DESC')->get(),
        ]);

    }

    public function create()
    {

        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        return inertia('Users/Create');

    }

    public function edit($id)
    {

        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        return inertia('Users/Update', [
            'user' => User::find($id),
        ]);

    }

    public function write(UserRequest $request)
    {

        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        $image = request()->file("image");

        $id = $request->id;

        $user = $id ? User::find($id) : new User;

        $user->email = $request->email;

        $user->name = $request->name;

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

    public function delete($id)
    {

        $authArray = array('user', 'delete');

        Helper::authorizeModel($authArray);

        $user = User::find($id);

        if ($user->image) {
            $imageFileExist = file_exists(public_path() . $user->image);

            $imageFileExist ? $imageFileDeleted = unlink(substr($user->image, 1)) : $imageFileDeleted = false;

            $imageFileExist ? ($imageFileDeleted ? $user->delete() : 1 == 1) : $user->delete();
        } else {
            $user->delete();
        }

    }

    public function deleteImage($id)
    {

        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        $user = User::find($id);

        $imageFileExist = file_exists(public_path() . $user->image);

        $imageFileExist ? $imageFileDeleted = unlink(substr($user->image, 1)) : $imageFileDeleted = false;

        $imageFileExist ? ($imageFileDeleted ? User::where('id', $id)->update(['image' => null]) : 1 == 1) : User::where('id', $id)->update(['image' => null]);

    }

    public function updateStatus($id)
    {

        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        $user = User::find($id);

        $user->status ? $user->status = 0 : $user->status = 1;

        $user->save();

    }

    public function updatePermissions(Request $request, $id)
    {

        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        $user = User::find($id);

        $permissionsNames = $request->permissionsNames;

        $permissionsIds = Permission::whereIn('name', $permissionsNames)->pluck('id')->all();

        $user->permissions()->sync($permissionsIds);

    }

    public function showPermissions($id)
    {
        $authArray = array('user', 'write');

        Helper::authorizeModel($authArray);

        return inertia('Users/Permissions', [
        'user' =>     User::with('permissions')->where('id', $id)->first(),
        'permissions' =>   User::find($id)->permissionsNames()

        ]);

    }

    public function exportExcel()
    {

        $authArray = array('user', 'show');

        Helper::authorizeModel($authArray);

        return Excel::download(new UserExport, 'users.xlsx');

    }

}
