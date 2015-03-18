<?php

namespace GingerPayments\Payment;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class Currency
{
    use ChoiceBasedValueObject;

    /**
     * Possible currencies
     */
    const EUR = 'EUR';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return [self::EUR];
    }
}
