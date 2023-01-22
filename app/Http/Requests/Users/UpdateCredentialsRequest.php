<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCredentialsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = (request()->get('user_id'));

        $updatePassword = (request()->get('updatePassword'));

        $passwordRule = $updatePassword ? 'required' : 'nullable';

        return [

            'username' => ['unique:users,username,' . $id, 'required', 'min:3', 'string', 'max:255'],

            "password" => [$passwordRule, "min:8", 'confirmed',

            ],

        ];
    }

}
