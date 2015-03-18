<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;

final class Transactions implements \Iterator
{
    /**
     * @var Transaction[]
     */
    private $transactions;

    /**
     * @return Transactions
     */
    public static function create()
    {
        return new static([]);
    }

    /**
     * @param array $transactions
     * @return Transactions
     */
    public static function fromArray(array $transactions)
    {
        return new static(
            array_map(
                function ($transaction) {
                    return Transaction::fromArray($transaction);
                },
                $transactions
            )
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(
            function (Transaction $transaction) {
                return $transaction->toArray();
            },
            $this->transactions
        );
    }

    /**
     * @return \GingerPayments\Payment\Url|null
     */
    public function firstPaymentUrl()
    {
        return array_key_exists(0, $this->transactions)
            ? $this->transactions[0]->paymentUrl()
            : null;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->transactions);
    }

    public function next()
    {
        return next($this->transactions);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->transactions);
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        $key = key($this->transactions);
        return ($key !== null && $key !== false);
    }

    public function rewind()
    {
        reset($this->transactions);
    }

    /**
     * @param Transaction[] $transactions
     */
    private function __construct(array $transactions = [])
    {
        Guard::allIsInstanceOf($transactions, 'GingerPayments\Payment\Order\Transaction');

        $this->transactions = $transactions;
    }
}
