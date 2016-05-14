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
        $result = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (count($value) > 0) {
                    $result[$key] = ArrayFunctions::withoutNullValues($value);
                }
                continue;
            }

            if ($value !== null) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
