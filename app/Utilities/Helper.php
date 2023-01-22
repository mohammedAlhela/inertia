<?php
namespace App\Utilities;

use Illuminate\Support\Facades\Gate;
use App\Providers\RouteServiceProvider;
use Image;
use Illuminate\Support\Facades\Auth;
class Helper
{

    public static function uploadImage($data)
    {
        if ($data["image"] ) {
            // delete old image
            if ($data["record"]->id && $data["record"]->image && file_exists(public_path() . $data["record"]->image  )) {
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
        return $permissions = ['admin-show' , 'admin-delete' , 'admin-update' , 'admin-create'

        

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

        Auth::attempt(['username' => $request->username, 'password' => $request->password]);
        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);

    }


}
