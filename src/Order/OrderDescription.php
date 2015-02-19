<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;

final class OrderDescription
{
    /**
     * @var string
     */
    private $description;

    /**
     * Factory method. Returns a new instance from a string.
     *
     * @param string $description
     * @return OrderDescription
     */
    public static function fromString($description)
    {
        return new static((string) $description);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->description;
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
    protected function __construct($value)
    {
        Guard::notBlank($value, 'Description cannot be blank');

        $this->description = $value;
    }
}
