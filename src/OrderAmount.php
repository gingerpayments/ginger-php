<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;

final class OrderAmount
{
    /**
     * @var integer
     */
    private $amount;

    /**
     * @param integer $amount
     * @return OrderAmount
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
        Guard::min($amount, 1, 'Order amount must be at least one cent');

        $this->amount = $amount;
    }

}
