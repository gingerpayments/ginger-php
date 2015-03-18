<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\Order;
use GingerPayments\Payment\Order\Transaction;

final class OrderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreate()
    {
        $order = Order::create(
            6500,
            'EUR',
            'credit-card',
            [],
            'My description',
            'my-order-id',
            'http://www.example.com',
            'P0Y0M0DT1H0M0S'
        );

        $this->assertEquals(6500, $order->amount()->toInteger());
        $this->assertEquals('EUR', (string) $order->currency());
        $this->assertEquals('My description', (string) $order->description());
        $this->assertEquals('my-order-id', (string) $order->merchantOrderId());
        $this->assertEquals('http://www.example.com', (string) $order->returnUrl());
        $this->assertEquals(
            'P0Y0M0DT1H0M0S',
            $order->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
        );

        /** @var Transaction $transaction */
        foreach ($order->transactions() as $transaction) {
            $this->assertEquals('credit-card', (string) $transaction->paymentMethod());
            $this->assertEquals(
                [],
                $transaction->paymentMethodDetails()->toArray()
            );
        }
    }

    /**
     * @test
     */
    public function itShouldCreateWithCreditCard()
    {
        $order = Order::createWithCreditCard(
            6500,
            'EUR',
            'My description',
            'my-order-id',
            'http://www.example.com',
            'P0Y0M0DT1H0M0S'
        );

        $this->assertEquals(6500, $order->amount()->toInteger());
        $this->assertEquals('EUR', (string) $order->currency());
        $this->assertEquals('My description', (string) $order->description());
        $this->assertEquals('my-order-id', (string) $order->merchantOrderId());
        $this->assertEquals('http://www.example.com', (string) $order->returnUrl());
        $this->assertEquals(
            'P0Y0M0DT1H0M0S',
            $order->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
        );

        /** @var Transaction $transaction */
        foreach ($order->transactions() as $transaction) {
            $this->assertEquals('credit-card', (string) $transaction->paymentMethod());
            $this->assertEquals(
                [],
                $transaction->paymentMethodDetails()->toArray()
            );
        }
    }

    /**
     * @test
     */
    public function itShouldCreateWithIdeal()
    {
        $order = Order::createWithIdeal(
            6500,
            'EUR',
            'ABNANL2A',
            'My description',
            'my-order-id',
            'http://www.example.com',
            'P0Y0M0DT1H0M0S'
        );

        $this->assertEquals(6500, $order->amount()->toInteger());
        $this->assertEquals('EUR', (string) $order->currency());
        $this->assertEquals('My description', (string) $order->description());
        $this->assertEquals('my-order-id', (string) $order->merchantOrderId());
        $this->assertEquals('http://www.example.com', (string) $order->returnUrl());
        $this->assertEquals(
            'P0Y0M0DT1H0M0S',
            $order->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
        );

        /** @var Transaction $transaction */
        foreach ($order->transactions() as $transaction) {
            $this->assertEquals('ideal', (string) $transaction->paymentMethod());
            $this->assertArraySubset(
                ['issuer_id' => 'ABNANL2A'],
                $transaction->paymentMethodDetails()->toArray()
            );
        }
    }

    /**
     * @test
     */
    public function itShouldCreateFromAnArray()
    {
        $array = [
            'transactions' => [],
            'amount' => 6200,
            'currency' => 'EUR',
            'description' => 'My amazing order',
            'merchant_order_id' => 'my-order-id',
            'return_url' => 'http://www.example.com',
            'expiration_period' => 'P0Y0M0DT1H0M0S',
            'id' => '6cc8bc83-c14a-4871-b91e-a8575db5556d',
            'project_id' => '4e8207ef-caf2-429e-a8e1-be8d628beccb',
            'created' => '2015-03-07T20:58:35+0100',
            'modified' => '2015-03-07T20:58:35+0100',
            'completed' => '2015-03-07T20:58:35+0100',
            'status' => 'new'
        ];

        $order = Order::fromArray($array);
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order',
            $order
        );

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transactions',
            $order->transactions()
        );
        $this->assertEquals($array['amount'], $order->amount()->toInteger());
        $this->assertEquals($array['currency'], (string) $order->currency());
        $this->assertEquals($array['description'], (string) $order->description());
        $this->assertEquals($array['merchant_order_id'], (string) $order->merchantOrderId());
        $this->assertEquals($array['return_url'], (string) $order->returnUrl());
        $this->assertEquals(
            $array['expiration_period'],
            $order->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
        );
        $this->assertEquals($array['id'], (string) $order->id());
        $this->assertEquals($array['project_id'], (string) $order->projectId());
        $this->assertEquals($array['created'], $order->created()->toIso8601String());
        $this->assertEquals($array['modified'], $order->modified()->toIso8601String());
        $this->assertEquals($array['completed'], $order->completed()->toIso8601String());
        $this->assertEquals($array['status'], (string) $order->status());
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingTransactions()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Order::fromArray([]);
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingAmount()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Order::fromArray(
            ['transactions' => []]
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingCurrency()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Order::fromArray(
            [
                'transactions' => [],
                'amount' => 1234
            ]
        );
    }

    /**
     * @test
     */
    public function itShouldSetMissingValuesToNull()
    {
        $array = [
            'transactions' => [],
            'amount' => 6200,
            'currency' => 'EUR'
        ];

        $order = Order::fromArray($array);
        $this->assertNull($order->description());
        $this->assertNull($order->merchantOrderId());
        $this->assertNull($order->returnUrl());
        $this->assertNull($order->expirationPeriod());
        $this->assertNull($order->id());
        $this->assertNull($order->projectId());
        $this->assertNull($order->created());
        $this->assertNull($order->modified());
        $this->assertNull($order->completed());
        $this->assertNull($order->status());
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
            'transactions' => [],
            'amount' => 6200,
            'currency' => 'EUR',
            'description' => 'My amazing order',
            'merchant_order_id' => 'my-order-id',
            'return_url' => 'http://www.example.com',
            'expiration_period' => 'P0Y0M0DT1H0M0S',
            'id' => '6cc8bc83-c14a-4871-b91e-a8575db5556d',
            'project_id' => '4e8207ef-caf2-429e-a8e1-be8d628beccb',
            'created' => '2015-03-07T20:58:35+0100',
            'modified' => '2015-03-07T20:58:35+0100',
            'completed' => '2015-03-07T20:58:35+0100',
            'status' => 'new'
        ];

        $this->assertEquals(
            $array,
            Order::fromArray($array)->toArray()
        );
    }
}
