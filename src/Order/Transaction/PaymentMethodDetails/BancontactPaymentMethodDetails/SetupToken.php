<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails;

use GingerPayments\Payment\Common\StringBasedValueObject;

final class SetupToken
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
