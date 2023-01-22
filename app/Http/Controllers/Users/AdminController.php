<?php

namespace App\Http\Controllers\Users;

use App\Exports\Users\AdminExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AdminRequest;
use App\Http\Requests\Users\EmailMessageRequest;
use App\Http\Requests\Users\UpdateCredentialsRequest;
use App\Mail\Users\CredentialsUpdatedMail;
use App\Mail\Users\EmailMessageMail;
use App\Mail\Users\UserCreatedMail;
use App\Models\Admin;
use App\Models\Permission;
use App\Models\User;
use Excel;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use PDF;

class AdminController extends Controller
{

    public function index()
    {

        return inertia('App/Admins/Index', [
            'admins' => Admin::all(),
        ]);

    }

    public function create()
    {
        return inertia('App/Admins/Create');
    }

    public function store(AdminRequest $request)
    {

        $password = Str::random(8);

        $user = User::create([
            'username' => explode("@", $request->email)[0],
            'password' => Hash::make($password),
            'password_label' => $password,
            'role' => 'admin',

        ]);

        $request['user_id'] = $user->id;

        $user->email = $request->email;

        Mail::to($user)->send(new UserCreatedMail($user));

        $image = request()->file("image");

        $admin = Admin::create($request->except('image', 'created_at', 'updated_at'));

        $data = array(
            "record" => $admin,
            "image" => $image,
            "dirPath" => "/images/admins/",
            "width" => 250,
            "height" => 250,

        );
        Helper::uploadImage($data);

    }

    public function edit($id)
    {

        return inertia('App/Admins/Edit', [
            'admin' => Admin::find($id),
        ]);

    }

    public function update(AdminRequest $request, $id)
    {

        $image = request()->file("image");

        $admin = Admin::update($request->except('image', 'created_at', 'updated_at'))->where('id', $id);

        $admin = Admin::find($id);

        $data = array(
            "record" => $admin,
            "image" => $image,
            "dirPath" => "/images/admins/",
            "width" => 250,
            "height" => 250,

        );
        Helper::uploadImage($data);
    }

    public function delete($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $admins = Admin::with('user')->whereIn('id', $ids)->get();

        foreach ($admins as $admin) {
            if ($admin->image && file_exists(public_path() . $admin->image)) {

                unlink(substr($admin->image, 1));

            }
            $admin->delete();
            $admin->user->delete();
        }

    }

    public function block($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        User::whereIn('id', $usersIds)->update(['status' => false]);

    }

    public function unblock($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        User::whereIn('id', $usersIds)->update(['status' => true]);

    }

    public function ShowPermissions($id)
    {

        return inertia('App/Admins/Permissions', [
            'permissions' => Admin::find($id)->user->permissions,
        ]);

    }

    public function UpdatePermissions(Request $request, $id)
    {

        $user_id = Admin::find($id)->user->id;

        $user = User::find($user_id);

        $permissionsNames = $request->permissionsNames;

        $permissionsIds = Permission::whereIn('name', $permissionsNames)->pluck('id')->all();

        $user->permissions()->sync($permissionsIds);

    }

    public function ShowCredentials($id)
    {

        return inertia('App/Admins/Credentials', [
            'username' => Admin::find($id)->user->username,
        ]);

    }

    public function UpdateCredentials(UpdateCredentialsRequest $request, $id)
    {
        $user_id = Admin::find($id)->user->id;

        $user = User::find($user_id);

        $user->username = $request->username;

        $user->temp_credentials = 0;

        $user->password_label = $request->password;

        $request->updatePassword ? $user->password = Hash::make($request['password']) : 1 == 1;

        $user->save();

        $user->email = Admin::find(1)->email;

        $request->logoutFromSessions ? DB::table('sessions')->where('user_id', $user->id)->where('ip_address', '!=', $request->ip())->delete() : 1 == 1;

        $request->sendUpdateNotification ? Mail::to($user)->send(new CredentialsUpdatedMail($user)) : 1 == 1;

    }

    public function emailMessage(EmailMessageRequest $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        $users = User::whereIn('id', $usersIds)->get();
        $admins = Admin::whereIn('id', $ids)->get();

        foreach ($admins as $admin) {
            foreach ($users as $user) {

                if ($admin->user_id == $user->id) {
                    $user->email = $admin->email;
                }

            }
        }

        foreach ($users as $user) {
            Mail::to($user)->send(new EmailMessageMail($request));
        }

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $admins = Admin::whereIn('id', $ids)->get();

        $pdf = PDF::loadView('admins.export.pdf', array('admins' => $admins));

        return $pdf->download('admins.pdf');
    }

    public function exportExcel(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);
        return Excel::download(new AdminExport($ids), 'admins.xlsx');
    }

}
