<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Repository implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(ssh|git|https?):\/\//', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute is not a valid Github repository';
    }
}
