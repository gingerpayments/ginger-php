<?php

namespace GingerPayments\Payment\Ideal\Issuer;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class ListType
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'Issuer list type cannot be blank');

        $this->value = $value;
    }
}
