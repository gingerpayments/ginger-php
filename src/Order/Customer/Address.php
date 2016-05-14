<?php

namespace GingerPayments\Payment\Order\Customer;

use GingerPayments\Payment\Common\StringBasedValueObject;

final class Address
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }
}
