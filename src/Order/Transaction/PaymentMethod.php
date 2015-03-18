<?php

namespace GingerPayments\Payment\Order\Transaction;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class PaymentMethod
{
    use ChoiceBasedValueObject;

    /**
     * Possible payment methods
     */
    const IDEAL = 'ideal';
    const CREDIT_CARD = 'credit-card';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return [
            self::IDEAL,
            self::CREDIT_CARD
        ];
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
