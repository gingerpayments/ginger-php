<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;

final class OrderCurrency
{
    /**
     * @var array
     */
    private static $validCurrencies;

    /**
     * @var string
     */
    private $currency;

    /**
     * @param string $currency
     * @return OrderCurrency
     */
    public static function fromString($currency)
    {
        return new static($currency);
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $currency
     */
    private function __construct($currency)
    {
        if (null === self::$validCurrencies) {
            self::$validCurrencies = require_once __DIR__ . '/OrderCurrency/currencies.php';
        }

        Guard::choice(
            $currency,
            array_keys(static::$validCurrencies),
            'Provided currency must be a valid currency'
        );

        $this->currency = $currency;
    }
}
