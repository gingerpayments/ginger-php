<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;
use IsoCodes\SwiftBic as SwiftBicValidator;

final class SwiftBic
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::true(
            empty($value) || SwiftBicValidator::validate($value),
            'Must be a valid BIC/SWIFT code (ISO-9362)'
        );

        $this->value = $value;
    }
}
