<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;

final class OrderReturnUrl
{
    /**
     * @var string
     */
    private $returnUrl;

    /**
     * Factory method. Returns a new instance from a string.
     *
     * @param string $returnUrl
     * @return OrderReturnUrl
     */
    public static function fromString($returnUrl)
    {
        return new static((string) $returnUrl);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->returnUrl;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $returnUrl
     */
    protected function __construct($returnUrl)
    {
        Guard::url($returnUrl, 'Order return URL must be a valid URL');

        $this->returnUrl = $returnUrl;
    }
}
