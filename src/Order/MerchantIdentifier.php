<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class MerchantIdentifier
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'Merchant identifier cannot be blank');

        $this->value = $value;
    }
}
