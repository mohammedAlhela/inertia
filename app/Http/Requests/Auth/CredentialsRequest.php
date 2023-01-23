<?php

namespace App\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CredentialsRequest extends FormRequest
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

        $updatePassword = request()->get('updatePassword');

        $passwordRule = $updatePassword ? 'required' : 'nullable';

        return [

            'email' => ['unique:users,email,' . auth()->user()->id, 'required', 'email', 'string', 'max:255'],

            "old_password" => [$passwordRule, 'current_password'],

            "password" => [$passwordRule, "min:8", 'confirmed'

            ],
            "password_confirmation" => ['required']

        

        ];
    }

}
