<?php

namespace App\Rules\Auth;

use DB;
use Illuminate\Contracts\Validation\Rule;

class ValidateEmailRule implements Rule
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

        return DB::table('users')->where('email', $value)->first();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'We cant find user with this email';
    }
}
