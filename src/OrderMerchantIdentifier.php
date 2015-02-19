<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;

final class OrderMerchantIdentifier
{
    /**
     * @var string
     */
    private $merchantIdentifier;

    /**
     * Factory method. Returns a new instance from a string.
     *
     * @param string $merchantIdentifier
     * @return OrderMerchantIdentifier
     */
    public static function fromString($merchantIdentifier)
    {
        return new static((string) $merchantIdentifier);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->merchantIdentifier;
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
        Guard::notBlank($value, 'Order merchant identifier cannot be blank');

        $this->merchantIdentifier = $value;
    }
}
