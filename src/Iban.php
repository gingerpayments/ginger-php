<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;
use IsoCodes\Iban as IbanValidator;

final class Iban
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::true(
            IbanValidator::validate($value),
            'Must be a valid IBAN (ISO 13616:2007)'
        );

        $this->value = $value;
    }
}
