<?php

namespace GingerPayments\Payment\Order\Transaction;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class Reference
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'Reference can not be empty!');

        $this->value = $value;
    }
}
