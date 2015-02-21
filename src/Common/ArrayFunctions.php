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
        $result = array();

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result[$key] = ArrayFunctions::withoutNullValues($value);
                continue;
            }

            if ($value !== null) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
