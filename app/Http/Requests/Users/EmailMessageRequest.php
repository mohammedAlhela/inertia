<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class EmailMessageRequest extends FormRequest
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
            'subject' => [ 'required', 'string', 'max:255'],
            'message' => [ 'required', 'min:10', 'string', 'max:500'],
        ];
    }

}
