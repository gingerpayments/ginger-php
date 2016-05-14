<?php

namespace GingerPayments\Payment\Common;

use Alcohol;

class ISO3166
{
    /**
     * Check if provided value is ISO 3166-1 alpha-2 country standard
     *
     * @param string $value
     * @return bool
     */
    public static function isValid($value)
    {
        try {
            $ISO3166 = new Alcohol\ISO3166();
            $ISO3166->getByAlpha2($value);
            return true;
        } catch (\DomainException $e) {
            return false;
        }
    }
}
