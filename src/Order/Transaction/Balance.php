<?php

namespace GingerPayments\Payment\Order\Transaction;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class Balance
{
    use ChoiceBasedValueObject;

    /**
     * Possible transaction value values
     */
    const INTERNAL = 'internal';
    const EXTERNAL = 'external';
    const TEST = 'test';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return [
            self::INTERNAL,
            self::EXTERNAL,
            self::TEST
        ];
    }

    /**
     * @return bool
     */
    public function isInternal()
    {
        return $this->value === self::INTERNAL;
    }

    /**
     * @return bool
     */
    public function isExternal()
    {
        return $this->value === self::EXTERNAL;
    }

    /**
     * @return bool
     */
    public function isTest()
    {
        return $this->value === self::TEST;
    }
}
