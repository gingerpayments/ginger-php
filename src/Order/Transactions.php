<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Order\Transaction;

final class Transactions implements \Iterator
{
    /**
     * @var Transaction[]
     */
    private $transactions;

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
     * @param Transaction $transaction
     */
    public function add(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
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
    private function __construct(array $transactions = array())
    {
        Guard::allIsInstanceOf($transactions, 'GingerPayments\Payment\Order\Transaction');

        $this->transactions = $transactions;
    }
}
