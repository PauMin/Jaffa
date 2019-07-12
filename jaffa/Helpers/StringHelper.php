<?php

namespace Jaffa\Helpers;

class StringHelper
{
    /**
     * @param string $string
     */
    public static function pluralize($string)
    {
        return $string . 's';
    }
}