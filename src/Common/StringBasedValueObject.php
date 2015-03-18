<?php

namespace GingerPayments\Payment\Common;

trait StringBasedValueObject
{
    /**
     * @var string
     */
    private $value;

    /**
     * Factory method. Returns a new instance from a string.
     *
     * @param string $value
     * @return static
     */
    public static function fromString($value)
    {
        return new self((string) $value);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }
}
