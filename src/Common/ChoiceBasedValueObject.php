<?php

namespace GingerPayments\Payment\Common;

use Assert\Assertion as Guard;

trait ChoiceBasedValueObject
{
    /**
     * @return array
     */
    public static function possibleValues()
    {
        return array();
    }

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::choice($value, static::possibleValues());

        $this->value = $value;
    }
}
