<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class Status
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'iDEAL status cannot be blank');

        $this->value = $value;
    }
}
