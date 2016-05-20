<?php

namespace GingerPayments\Payment\Common;

final class ArrayFunctions
{
    /**
     * Returns a new array with all elements which have a null value removed.
     *
     * @param array $array
     * @return array
     */
    public static function withoutNullValues(array $array)
    {
        static $fn = __FUNCTION__;

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = self::$fn($array[$key]);
            }

            if (empty($array[$key])) {
                unset($array[$key]);
            }
        }

        return $array;
    }
}
