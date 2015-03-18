<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Transaction;
use GingerPayments\Payment\Order\Transactions;

final class TransactionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreate()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transactions',
            Transactions::create()
        );
    }

    /**
     * @test
     */
    public function itShouldCreateFromArray()
    {
        $array = [['payment_method' => 'credit-card']];

        $transactions = Transactions::fromArray($array);
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transactions',
            $transactions
        );
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
            [
                'payment_method' => 'credit-card',
                'payment_method_details' => [],
                'id' => '5ac3eb32-384d-4d61-a797-9f44b1cd70e5',
                'created' => '2015-03-07T20:58:35+0100',
                'modified' => '2015-03-07T21:58:35+0100',
                'completed' => '2015-03-07T22:58:35+0100',
                'status' => 'new',
                'reason' => 'A great reason',
                'currency' => 'EUR',
                'amount' => 3400,
                'expiration_period' => 'P0Y0M0DT1H0M0S',
                'description' => 'A transaction',
                'balance' => 'internal',
                'payment_url' => 'http://www.example.com'
            ]
        ];

        $this->assertEquals(
            $array,
            Transactions::fromArray($array)->toArray()
        );
    }

    /**
     * @test
     */
    public function itShouldBeTraversable()
    {
        $array = [
            ['payment_method' => 'credit-card'],
            ['payment_method' => 'credit-card']
        ];

        $transactions = Transactions::fromArray($array);
        $iterations = 0;
        foreach ($transactions as $key => $transaction) {
            $this->assertEquals($iterations, $key);
            $this->assertInstanceOf('GingerPayments\Payment\Order\Transaction', $transaction);
            $iterations++;
        }
        $this->assertEquals(2, $iterations);
    }

    /**
     * @test
     */
    public function itShouldGetTheFirstPaymentUrl()
    {
        $transactions = Transactions::fromArray(
            [['payment_method' => 'credit-card', 'payment_url' => 'http://www.example.com']]
        );
        $this->assertEquals('http://www.example.com', $transactions->firstPaymentUrl());
    }
}
