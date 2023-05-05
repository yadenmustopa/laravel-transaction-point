<?php

//epochToDate

use Carbon\Carbon;

if (!function_exists('epochToDate')) {
    /**
     * epochToDate
     *
     * @param  string|int $date
     * @return string
     */
    function epochToDate(string|int $epoch, $format = "Y-m-d"): string
    {
        return Carbon::createFromTimestampMsUTC($epoch)->format($format);
    }

    //isValidTimeStamp
    if (!function_exists('isValidTimeStamp')) {
        /**
         * isValidTimeStamp
         * source for https://stackoverflow.com/questions/2524680/check-whether-the-string-is-a-unix-timestamp
         *
         * @param  mixed $timestamp
         * @return bool
         */
        function isValidTimeStamp(mixed $timestamp): bool
        {
            return ((string) (int) $timestamp === $timestamp)
                && ($timestamp <= PHP_INT_MAX)
                && ($timestamp >= ~PHP_INT_MAX);
        }
    }

    //camelToDashCase
    if (!function_exists('camelToDashCase')) {
        /**
         * camelToDashCase
         *
         * @param  string $name
         * @return string
         */
        function camelToDashCase($name)
        {
            return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '-$0', $name)), '-');
        }
    }
}
