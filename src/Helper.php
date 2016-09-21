<?php

/**
 * Declare bcmod function in case when BCMath extension is not installed
 */
if (!function_exists('bcmod')) {
    /**
     * http://php.net/manual/en/function.bcmod.php
     *
     * @param int $x
     * @param int  $y
     * @return string modulus
     */
    function bcmod($x, $y)
    {
        $take = 5;
        $mod = '';

        do {
            $a = (int) $mod.substr($x, 0, $take);
            $x = substr($x, $take);
            $mod = $a % $y;
        } while (strlen($x));

        return (string) $mod;
    }
}
