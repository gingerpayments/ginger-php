<?php

namespace GingerPayments\Payment\Common;

use Assert\Assertion as Guard;

trait ChoiceBasedValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * @return array
     */
    public abstract function possibleValues();

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        Guard::choice($value, $this->possibleValues());

        $this->value = $value;
    }
}
