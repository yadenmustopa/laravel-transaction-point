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
         * @param  string $timestamp
         * @return bool
         */
        function isValidTimeStamp(string $timestamp): bool
        {
            return ((string) (int) $timestamp === $timestamp)
                && ($timestamp <= PHP_INT_MAX)
                && ($timestamp >= ~PHP_INT_MAX);
        }
    }
}
