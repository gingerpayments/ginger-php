<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class TransactionId
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::notBlank($value, 'iDEAL transaction ID cannot be blank');

        $this->value = $value;
    }
}
