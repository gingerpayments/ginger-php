<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class Url
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::url($value, 'URL must be a valid URL');

        $this->value = $value;
    }
}
