<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails;

use GingerPayments\Payment\Common\StringBasedValueObject;

final class VaultToken
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }
}
