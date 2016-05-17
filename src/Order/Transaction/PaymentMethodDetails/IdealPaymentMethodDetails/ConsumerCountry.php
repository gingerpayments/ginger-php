<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use GingerPayments\Payment\Common\StringBasedValueObject;
use GingerPayments\Payment\Common\ISO3166;
use Assert\Assertion as Guard;

final class ConsumerCountry
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::true(
            empty($value) || ISO3166::isValid($value),
            'Consumer country must have ISO 3166-1 alpha-2 country standard.'
        );

        $this->value = $value;
    }
}
