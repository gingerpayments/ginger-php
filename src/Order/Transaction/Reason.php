<?php

namespace GingerPayments\Payment\Order\Transaction;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class Reason
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'Transaction reason cannot be blank');

        $this->value = $value;
    }
}
