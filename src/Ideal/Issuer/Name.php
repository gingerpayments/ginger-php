<?php

namespace GingerPayments\Payment\Ideal\Issuer;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class Name
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'Issuer name cannot be blank');

        $this->value = $value;
    }
}
