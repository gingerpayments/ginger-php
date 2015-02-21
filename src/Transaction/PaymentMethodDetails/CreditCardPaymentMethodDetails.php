<?php

namespace GingerPayments\Payment\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Transaction\PaymentMethodDetails;

final class CreditCardPaymentMethodDetails implements PaymentMethodDetails
{
    /**
     * @param array $details
     * @return CreditCardPaymentMethodDetails
     */
    public static function fromArray(array $details)
    {
        return new static();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array();
    }
}
