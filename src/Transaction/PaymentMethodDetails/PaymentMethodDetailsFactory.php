<?php

namespace GingerPayments\Payment\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Transaction\PaymentMethod;

final class PaymentMethodDetailsFactory
{
    public static function createFromArray(PaymentMethod $paymentMethod, array $paymentMethodDetails)
    {
        if ($paymentMethod->isIdeal()) {
            return IdealPaymentMethodDetails::fromArray($paymentMethodDetails);
        }

        if ($paymentMethod->isCreditCard()) {
            return CreditCardPaymentMethodDetails::fromArray($paymentMethodDetails);
        }

        throw new \InvalidArgumentException('Provided payment method not supported.');
    }
}
