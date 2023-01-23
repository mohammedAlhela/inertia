<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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

        $id = request()->get('id');

        $emailRule = $id ? 'nullable' : 'required';

        return [
            'email' => [$emailRule, 'unique:users,email', 'email', 'string', 'max:255'],
            'first_name' => ['required', 'min:3', 'string', 'max:255'],
            'last_name' => ['required', 'min:3', 'string', 'max:255'],
            'username' => ['required', 'min:3', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:10', 'max:11'],
            'image' => ['nullable', 'image', 'max:500'],
            'address' => ['nullable', 'max:500'],
        ];
    }

}
