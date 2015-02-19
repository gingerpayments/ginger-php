<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;

final class OrderIdentifier
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * Factory method. Returns a new instance from a string.
     *
     * @param string $identifier
     * @return OrderIdentifier
     */
    public static function fromString($identifier)
    {
        return new static((string) $identifier);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $identifier
     */
    private function __construct($identifier)
    {
        Guard::uuid($identifier, 'The identifier must be a valid UUID');

        $this->identifier = $identifier;
    }
}
