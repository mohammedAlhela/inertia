<?php
namespace App\Utilities;

use App\Models\Company;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Image;

class Helper
{

    public static function uploadImage($data)
    {
        if ($data["image"]) {
            // delete old image
            if ($data["record"]->id && $data["record"]->image && file_exists(public_path() . $data["record"]->image)) {
                unlink(substr($data["record"]->image, 1));
            }
            // delete old image

            $imageName = time() . '.webp';
            Image::make($data["image"])->fit($data["width"], $data["height"])->save(public_path($data["dirPath"]) . $imageName);
            $data["record"]->image = $data["dirPath"] . $imageName;
        }

        $data["record"]->save();

    }

    public static function getArrayFromString($stringData)
    {
        $arayData = array();
        $arayData = str_replace("[", "", $stringData);
        $arayData = str_replace("]", "", $arayData);
        $arayData = explode(",", $arayData);
        return $arayData;
    }

    public static function getPermissions()
    {
        return $permissions = [
        'admin-show', 'admin-delete', 'admin-update', 'admin-store',
        'company-show',  'company-update',
        'academicYear-show', 'academicYear-delete', 'academicYear-update', 'academicYear-store',
        'academicTerm-show', 'academicTerm-delete', 'academicTerm-update', 'academicTerm-store',
        ];
    }

    public static function authorizeModel($authArray)
    {

        if (!Gate::allows('manage-model', $authArray)) {

            abort(403);
        }
    }

    public static function can($model, $action, )
    {

        return in_array("{$model}:{$action}", auth()->user()->permissionsNames());

    }

    public static function login($request)
    {

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);

    }

    public static function getCompany()
    {

        return Company::find(1);

    }

}
