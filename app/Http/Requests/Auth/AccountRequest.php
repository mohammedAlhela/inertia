<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        $id = app('request')->get('id');

        return [

            'name' => [ 'required', 'min:3', 'string', 'max:255'],
            'username' => ['unique:users,username,' . $id, 'required', 'min:3', 'string', 'max:255'],
            'email' => ['unique:users,email,' . $id, 'required', 'min:3', 'string', 'email', 'max:255'],
            'mobile' => [ 'required', 'string', 'min:10' , 'max:11' ],
            'image' => ['nullable', 'image'],
            'address' => ['nullable', 'max:500'],
           

        ];
    }

}
