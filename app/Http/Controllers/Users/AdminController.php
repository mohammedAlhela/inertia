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
use DB;
use Excel;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use PdfReport;

class AdminController extends Controller
{

    public function index()
    {

        $authArray = array('admin', 'show');

        Helper::authorizeModel($authArray);

        $admins = Admin::with('user')->get();

        foreach ($admins as $admin) {

            $admin->select = false;
        }
        return inertia('App/Users/Admins/Index', [
            'admins' => $admins,
        ]);

    }

    public function create()
    {

        $authArray = array('admin', 'store');

        Helper::authorizeModel($authArray);

        return inertia('App/Users/Admins/Create');
    }

    public function store(AdminRequest $request)
    {

        $authArray = array('admin', 'store');

        Helper::authorizeModel($authArray);

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

        Mail::send('users.userCreated', array('data' => $data), function ($mail) use ($user) {
            $mail->to($user->email)
                ->subject('New user created');

        });

        $image = request()->file("image");

        $admin = Admin::create($request->except('image', 'email', 'created_at', 'updated_at'));

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

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        return inertia('App/Users/Admins/Edit', [
            'admin' => Admin::find($id),
        ]);

    }

    public function update(AdminRequest $request, $id)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $image = request()->file("image");

        $admin = Admin::where('id', $id)->update($request->except('image', 'email', 'created_at', 'updated_at'));

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

        $authArray = array('admin', 'delete');

        Helper::authorizeModel($authArray);

        $ids = Helper::getArrayFromString($ids);

        $admins = Admin::with('user')->whereIn('id', $ids)->get();

        foreach ($admins as $admin) {
            if ($admin->image && file_exists(public_path() . $admin->image)) {

                unlink(substr($admin->image, 1));

            }
            $admin->user->delete();
            $admin->delete();

        }

    }

    public function block($ids)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        User::whereIn('id', $usersIds)->update(['status' => false]);

    }

    public function unBlock($ids)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        User::whereIn('id', $usersIds)->update(['status' => true]);

    }

    public function showPermissions($id)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $admin = Admin::find($id);
        return inertia('App/Users/Admins/Permissions', [
            'permissionsNames' => $admin->user->permissionsNames(),
            'admin' => $admin,
        ]);

    }

    public function updatePermissions(Request $request, $id)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $user_id = Admin::find($id)->user->id;

        $user = User::find($user_id);

        $permissionsNames = $request->permissionsNames;

        $permissionsIds = Permission::whereIn('name', $permissionsNames)->pluck('id')->all();

        $user->permissions()->sync($permissionsIds);

    }

    public function showCredentials($id)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $admin = Admin::find($id);
        return inertia('App/Users/Admins/Credentials', [
            'email' => $admin->user->email,
            'admin' => $admin,
        ]);

    }

    public function updateCredentials(CredentialsRequest $request, $id)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $admin = Admin::find($id);

        $user = User::find($request->user_id);

        $user->email = $request->email;

        $user->temp_credentials = 0;

        $user->password_label = $request->password;

        $request->updatePassword ? $user->password = Hash::make($request['password']) : 1 == 1;

        $user->save();

        $user->username = $admin->username;

        $data = array(
            'user' => $user,
            'company' => Helper::getCompany(),
        );

        $request->logoutFromSessions ? DB::table('sessions')->where('user_id', $user->id)->delete() : 1 == 1;

        $request->sendUpdateNotification ? Mail::send('users.credentialsUpdated', array('data' => $data), function ($mail) use ($user) {
            $mail->to($user->email)
                ->subject('User Credentials Updated ');

        }) : 1 == 1;

    }

    public function showEmailMessage($ids)
    {

        $ids = Helper::getArrayFromString($ids);

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);


       $adminsIds =  Admin::with('user')->whereIn('id' , $ids)->pluck('id')->toArray();
       $emails = User::whereIn('id' , $adminsIds)->pluck('email')->toArray();


        return inertia('App/Users/Admins/EmailMessage', [
            'ids' => $ids,
            'emails' => $emails 
        ]);

    }

    public function sendEmailMessage(EmailMessageRequest $request, $ids)
    {

        $authArray = array('admin', 'update');

        Helper::authorizeModel($authArray);

        $data = array(
            'subject' => $request->subject,
            'details' => $request->message,
            'company' => Helper::getCompany(),
        );

        $ids = Helper::getArrayFromString($ids);

        $usersIds = Admin::with('user')->whereIn('id', $ids)->pluck('user_id')->toArray();

        $emails = User::whereIn('id', $usersIds)->pluck('email')->toArray();

        $files = request()->file("files");

        $paths = array();


        if ($files) {
            foreach ($files as $file) {

                $file->move('send', $file->getClientOriginalName());

                array_push($paths, 'send/' . $file->getClientOriginalName());
            }
        }

        Mail::send('users.emailMessage', array('data' => $data), function ($mail) use ($data, $emails, $paths) {
            $mail->to($emails)
                ->subject($data['subject']);

            if (count($paths)) {
                foreach ($paths as $path) {
                    $mail->attach($path);

                }
            }

        });

        if (count($paths)) {
            foreach ($paths as $path) {
                file_exists($path) ? unlink($path) : 1 == 1;
            }

        }

    }

    public function exportPdf(Request $request, $ids)
    {

        $authArray = array('admin', 'show');

        Helper::authorizeModel($authArray);

        $ids = Helper::getArrayFromString($ids);

        $admins = Admin::with('user')->whereIn('id', $ids)->get();

        $data = array(
            'admins' => $admins,
            'company' => Helper::getCompany(),
        );

        $pdf = PdfReport::loadView('users.admins.pdf', array('data' => $data));
        return $pdf->download('admins.pdf');

    }

    public function exportExcel($ids)
    {

        $authArray = array('admin', 'show');

        Helper::authorizeModel($authArray);
        $ids = Helper::getArrayFromString($ids);

        return Excel::download(new AdminExport($ids), 'admins.xlsx');
    }

}
