<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * Truncate the given string to the specified length and add ellipsis if necessary.
     *
     * @param string $string
     * @param int $length
     * @return string
     */
    public static function truncate($string, $length = 50)
    {
        if (strlen($string) > $length) {
            return substr($string, 0, $length) . '...';
        }
        return $string;
    }
}
