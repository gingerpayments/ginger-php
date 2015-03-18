<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

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
        return [];
    }
}
