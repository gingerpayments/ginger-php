<?php

namespace GingerPayments\Payment\Transaction;

interface PaymentMethodDetails
{
    /**
     * @param array $details
     * @return PaymentMethodDetails
     */
    public static function fromArray(array $details);

    /**
     * @return array
     */
    public function toArray();
}
