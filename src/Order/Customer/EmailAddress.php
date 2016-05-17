<?php

namespace GingerPayments\Payment\Order\Customer;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class EmailAddress
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        if (!empty($value)) {
            Guard::email($value, 'Email Address is invalid');
        }

        $this->value = $value;
    }
}
