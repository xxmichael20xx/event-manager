<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneChecker implements Rule
{
    protected $message;
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
        if ( strlen( $value ) < 11 ) {
            $this->message = 'Phone number must be 11 numbers';
            return false;
        }

        if ( substr( $value, 0, 2 ) !== '09' ) {
            $this->message = 'Phone number must start with `09`';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
