<?php

/**
 * http://php.net/manual/en/function.bcmod.php
 *
 * @param string $x
 * @param string $y
 * @return string modulus
 */
function my_bcmod($x, $y)
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

/**
 * Declare bcmod function in case when BCMath extension is not installed
 */
if (!function_exists('bcmod')) {
    function bcmod($x, $y)
    {
        return my_bcmod($x, $y);
    }
}
