<?php

namespace GingerPayments\Payment\Order\Customer;

use GingerPayments\Payment\Common\StringBasedValueObject;
use Assert\Assertion as Guard;

final class Locale
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        if (!empty($value)) {
            Guard::regex($value, '/^[a-zA-Z]{2}(_[a-zA-Z]{2})?$/', "Locale : ".$value);
        }

        $this->value = $value;
    }
}
