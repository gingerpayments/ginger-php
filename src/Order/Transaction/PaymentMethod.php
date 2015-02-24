<?php

namespace GingerPayments\Payment\Order\Transaction;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;
use GingerPayments\Payment\Common\StringBasedValueObject;

final class PaymentMethod
{
    use StringBasedValueObject, ChoiceBasedValueObject;

    /**
     * Possible payment methods
     */
    const IDEAL = 'ideal';
    const CREDIT_CARD = 'cc';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return array(
            self::IDEAL,
            self::CREDIT_CARD
        );
    }

    /**
     * @return bool
     */
    public function isIdeal()
    {
        return $this->value === self::IDEAL;
    }

    /**
     * @return bool
     */
    public function isCreditCard()
    {
        return $this->value === self::CREDIT_CARD;
    }
}
