<?php

namespace App\Rules\Auth;

use Carbon\Carbon;
use DB;
use Illuminate\Contracts\Validation\Rule;

class ValidateTokenRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $token = app('request')->get('token');

        $record = DB::table('user_password')->where('email', $value)->where('token', $token)->first();

        return $record && Carbon::now()->subMinutes(30) < $record->created_at;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Token is invalid';
    }
}
