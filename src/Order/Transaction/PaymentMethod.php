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
    const BANK_TRANSFER = 'sepa-debit-transfer';
    const SOFORT = 'sofort';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return [
            self::IDEAL,
            self::CREDIT_CARD,
            self::BANK_TRANSFER,
            self::SOFORT
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

    /**
     * @return bool
     */
    public function isBankTransfer()
    {
        return $this->value === self::BANK_TRANSFER;
    }

    /**
     * @return bool
     */
    public function isSofort()
    {
        return $this->value === self::SOFORT;
    }
}
