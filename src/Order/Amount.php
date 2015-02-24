<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;

final class Amount
{
    /**
     * @var integer
     */
    private $amount;

    /**
     * @param integer $amount
     * @return Amount
     */
    public static function fromInteger($amount)
    {
        return new static((int) $amount);
    }

    /**
     * @return integer
     */
    public function toInteger()
    {
        return $this->amount;
    }

    /**
     * @param integer $amount
     */
    private function __construct($amount)
    {
        Guard::min($amount, 1, 'Amount must be at least one');

        $this->amount = $amount;
    }
}
