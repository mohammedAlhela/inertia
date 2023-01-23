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

        return [
            'first_name' => [ 'required', 'min:3', 'string', 'max:255'],
            'last_name' => [ 'required', 'min:3', 'string', 'max:255'],
            'username' => ['required', 'min:3', 'string', 'max:255'],
            'phone' => [ 'required', 'string', 'min:10' , 'max:11' ],
            'image' => ['nullable', 'image'  , 'max:500'],
            'address' => ['nullable', 'max:500'],
        ];
    }

}
