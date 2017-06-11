<?php

namespace GingerPayments\Payment\Common;

use League\ISO3166\ISO3166 as LeagueISO3166;

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
            $ISO3166 = new LeagueISO3166();
            $ISO3166->getByAlpha2($value);
            return true;
        } catch (\DomainException $e) {
            return false;
        }
    }
}
