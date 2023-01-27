<?php

namespace App\Http\Requests\Main;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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

        return [
            'name' => [  'unique:departments,name,' . $id, 'required', 'min:3', 'string', 'max:255'],
        ];
    }

}
