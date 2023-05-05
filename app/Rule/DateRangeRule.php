<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateRangeRule implements Rule
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
        $dateRanges = explode(',', $value);
        return count($dateRanges) === 3;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be string with format : column,start date(epoch), end date(epoch)';
    }
}