<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethod;

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

        if ($paymentMethod->isBankTransfer()) {
            return SepaPaymentMethodDetails::fromArray($paymentMethodDetails);
        }

        if ($paymentMethod->isSofort()) {
            return SofortPaymentMethodDetails::fromArray($paymentMethodDetails);
        }

        throw new \InvalidArgumentException('Provided payment method not supported.');
    }
}
