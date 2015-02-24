<?php

namespace GingerPayments\Payment;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class Currency
{
    use StringBasedValueObject, ChoiceBasedValueObject;

    /**
     * Possible currencies
     */
    const EUR = 'EUR';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return array(
            self::EUR
        );
    }
}
