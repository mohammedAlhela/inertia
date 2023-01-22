<?php

namespace App\Http\Requests\Auth;

use App\Rules\Auth\CurrentPasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class AccountCredentialsRequest extends FormRequest
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

        $updatePassword = (request()->get('updatePassword'));

        $passwordRule = $updatePassword ? 'required' : 'nullable';

        return [

            'username' => ['unique:users,username,' . auth()->user()->id, 'required', 'min:3', 'string', 'max:255'],

            "old_password" => [$passwordRule, new CurrentPasswordRule()],

            "password" => [$passwordRule, "min:8", 'confirmed'

            ],

        ];
    }

}
