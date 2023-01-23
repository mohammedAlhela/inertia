<?php

namespace App\Http\Controllers\Users;

use App\Exports\Users\AdminExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AdminRequest;
use App\Http\Requests\Users\CredentialsRequest;
use App\Http\Requests\Users\EmailMessageRequest;
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

        return inertia('App/Users/Admins/Index', [
            'admins' => Admin::all(),
        ]);

    }

    public function create()
    {
        return inertia('App/Users/Admins/Create');
    }

    public function store(AdminRequest $request)
    {

        $password = Str::random(8);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($password),
            'password_label' => $password,
            'role' => 'admin',

        ]);

        $request['user_id'] = $user->id;

        $user->username = $request->username;

        $data = array(
            'user' => $user,
            'company' => Helper::getCompany(),
        );

        Mail::send('auth.userCreated', array ('data' => $data), function ($mail) use ( $user) {
            $mail->to($user->email)
                ->subject('New user created');

        });

        $image = request()->file("image");

        $admin = Admin::create($request->except('image', 'email', 'created_at', 'updated_at'));

        $data = array(
            "record" => $admin,
            "image" => $image,
            "dirPath" => "images/admins/",
            "width" => 250,
            "height" => 250,

        );
        Helper::uploadImage($data);

    }

    public function edit($id)
    {

        return inertia('App/Users/Admins/Edit', [
            'admin' => Admin::find($id),
        ]);

    }

    public function update(AdminRequest $request, $id)
    {

        $image = request()->file("image");

        $admin = Admin::update($request->except('image', 'email', 'created_at', 'updated_at'))->where('id', $id);

        $admin = Admin::find($id);

        $data = array(
            "record" => $admin,
            "image" => $image,
            "dirPath" => "images/admins/",
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
            if ($admin->image && file_exists($admin->image)) {

                unlink($admin->image);

            }
            $admin->delete();
            $admin->user->delete();
        }

    }

    public function block($ids, $key)
    {

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        User::whereIn('id', $usersIds)->update(['status' => $key == 'block' ? false : true]);

    }

    public function ShowPermissions($id)
    {

        return inertia('App/Users/Admins/Permissions', [
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

        return inertia('App/Users/Admins/Credentials', [
            'email' => Admin::find($id)->user->email,
        ]);

    }

    public function UpdateCredentials(CredentialsRequest $request, $id)
    {
        $user_id = Admin::find($id)->user->id;

        $user = User::find($user_id);

        $user->email = $request->email;

        $user->temp_credentials = 0;

        $user->password_label = $request->password;

        $request->updatePassword ? $user->password = Hash::make($request['password']) : 1 == 1;

        $user->save();

        $user->username = Admin::find($id)->username;

        $data = array(
            'user' => $user,
            'company' => Helper::getCompany(),
        );

        $request->logoutFromSessions ? DB::table('sessions')->where('user_id', $user->id)->where('ip_address', '!=', $request->ip())->delete() : 1 == 1;

        $request->sendUpdateNotification ? Mail::send('auth.credentialsUpdated', array('data' => $data), function ($mail) use ($user) {
            $mail->to($user->email)
                ->subject('User Credentials Updated ');

        }) : 1 == 1;

    }

    public function emailMessage(EmailMessageRequest $request, $ids)
    {

        $data = array(
            'subject' => $request->subject,
            'details' => $request->message,
            'company' => Helper::getCompany(),
        );

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        $users = User::whereIn('id', $usersIds)->get();

        $emails = $users->pluck('email')->toArray();

        $files = request()->file("files");

        $paths = array();

        foreach ($files as $file) {

            $file->move('send', $file->getClientOriginalName());

            array_push($paths, 'send/' . $file->getClientOriginalName());
        }

        Mail::send('users.emailMessage', array('data' => $data), function ($mail) use ($data, $emails, $paths) {
            $mail->to($emails)
                ->subject($data['subject']);

            foreach ($paths as $path) {
                $mail->attach($path);

            }
        });

        foreach ($paths as $path) {
            file_exists($path) ? unlink($path) : 1 == 1;
        }

    }

    public function exportPdf(Request $request, $ids)
    {
        $ids = Helper::getArrayFromString($ids);

        $admins = Admin::with('user')->whereIn('id', $ids)->get();

        $pdf = PDF::loadView('users.admins.pdf', $admins);

        return $pdf->download('admins.pdf');
    }

    public function exportExcel($ids)
    {
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new AdminExport($ids), 'admins.xlsx');
    }

}
