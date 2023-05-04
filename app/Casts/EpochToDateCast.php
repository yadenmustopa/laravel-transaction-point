<?php

namespace App\Casts;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Summary of EpochToDateCast
 * @author Yaden Mustopa
 * @copyright (c) 2023
 */
class EpochToDateCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return ($value) ? (int) Carbon::parse($value)->format('Uv') : NULL;
    }

    /**
     * Prepare the given value for storage.
     * source : https://stackoverflow.com/questions/18562684/how-to-get-database-field-type-in-laravel
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value) {
            return NULL;
        }

        if (!isValidTimeStamp($value)) {
            return $value;
        }

        return epochToDate($value, "Y-m-d");
    }
}
