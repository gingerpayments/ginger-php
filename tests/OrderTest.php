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
        $customer = [
            'address' => "Radarweg 29 A-12 1043 NX Amsterdam",
            'address_type' => "customer",
            'country' => "NL",
            'email_address' => "email@example.com",
            'first_name' => "Name",
            'last_name' => "Lastname",
            'merchant_customer_id' => "2",
            'phone_numbers' => ["01234567890"],
            'postal_code' => "1043 NX",
            'housenumber' => "29 A-12"
        ];

        $order = Order::create(
            6500,
            'EUR',
            'credit-card',
            [],
            'My description',
            'my-order-id',
            'http://www.example.com',
            'P0Y0M0DT1H0M0S',
            $customer
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
        $customer = [
            'address' => "Radarweg 29 A-12 1043 NX Amsterdam",
            'address_type' => "customer",
            'country' => "NL",
            'email_address' => "email@example.com",
            'first_name' => "Firstname",
            'last_name' => "Lastname",
            'merchant_customer_id' => "2",
            'phone_numbers' => ["0123456789"],
            'postal_code' => "1043 NX",
            'housenumber' => "29 A-12"
        ];

        $order = Order::createWithCreditCard(
            6500,
            'EUR',
            'My description',
            'my-order-id',
            'http://www.example.com',
            'P0Y0M0DT1H0M0S',
            $customer
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
        $customer = [
            'address' => "Radarweg 29 A-12 1043 NX Amsterdam",
            'address_type' => "customer",
            'country' => "NL",
            'email_address' => "email@example.com",
            'first_name' => "Firstname",
            'last_name' => "Lastname",
            'merchant_customer_id' => "2",
            'phone_numbers' => ["0123456789"],
            'postal_code' => "1043 NX",
            'housenumber' => "29 A-12"
        ];

        $order = Order::createWithIdeal(
            6500,
            'EUR',
            'ABNANL2A',
            'My description',
            'my-order-id',
            'http://www.example.com',
            'P0Y0M0DT1H0M0S',
            $customer
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
        $customer = [
            'address' => "Radarweg 29 A-12 1043 NX Amsterdam",
            'address_type' => "customer",
            'country' => "NL",
            'email_address' => "email@example.com",
            'first_name' => "Firstname",
            'last_name' => "Lastname",
            'merchant_customer_id' => "2",
            'phone_numbers' => ["0123456789"],
            'postal_code' => "1043 NX",
            'housenumber' => "29 A-12"
        ];

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
            'status' => 'new',
            'customer' => $customer
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
        $customer = [
            'address' => "Radarweg 29 A-12 1043 NX Amsterdam",
            'address_type' => "customer",
            'country' => "NL",
            'email_address' => "email@example.com",
            'first_name' => "Firstname",
            'last_name' => "Lastname",
            'merchant_customer_id' => "2",
            'phone_numbers' => ["0123456789"],
            'postal_code' => null,
            'housenumber' => null,
            'locale' => null
        ];

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
            'status' => 'new',
            'customer' => $customer,
            'extra' => null
        ];

        $this->assertEquals(
            $array,
            Order::fromArray($array)->toArray()
        );
    }

    /**
     * @test
     */
    public function itShouldGetTheFirstTransactionPaymentUrl()
    {
        $array = [
            'transactions' => [
                [
                    'payment_method' => 'credit-card',
                    'payment_url' => 'http://www.example.com'
                ]
            ],
            'amount' => 6200,
            'currency' => 'EUR'
        ];

        $order = Order::fromArray($array);
        $this->assertEquals('http://www.example.com', $order->firstTransactionPaymentUrl());
    }

    /**
     * @test
     */
    public function itShouldUpdateFieldsThatAreNotReadOnly()
    {
        $customer = [
            'address' => "Radarweg 29 A-12 Amsterdam",
            'address_type' => "customer",
            'country' => "NL",
            'email_address' => "email@example.com",
            'first_name' => "Firstname",
            'last_name' => "Lastname",
            'merchant_customer_id' => "2",
            'phone_numbers' => ["0123456789"],
            'postal_code' => "1043 NX",
            'housenumber' => "29",
            'locale' => "en_US"
        ];

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
            'status' => 'new',
            'customer' => $customer,
            'extra' => null
        ];

        $updatedOrder = [
            'transactions' => [],
            'amount' => 9999,
            'currency' => 'EUR',
            'description' => 'New Order Description',
            'merchant_order_id' => 'NEW_MERCHANT_ORDER_ID',
            'return_url' => 'http://www.example.com/API',
            'expiration_period' => 'P0Y0M0DT2H0M0S',
            'id' => '6cc8bc83-c14a-4871-b91e-a8575db5556d',
            'project_id' => '4e8207ef-caf2-429e-a8e1-be8d628beccb',
            'created' => '2015-03-07T20:58:35+0100',
            'modified' => '2015-03-07T20:58:35+0100',
            'completed' => '2015-03-07T20:58:35+0100',
            'status' => 'new',
            'customer' => $customer,
            'extra' => null
        ];


        $order = Order::fromArray($array);

        $this->assertEquals(
            $order->toArray(),
            $array
        );

        $order->merchantOrderId("NEW_MERCHANT_ORDER_ID");

        $this->assertNotEquals(
            $order->toArray(),
            $array
        );

        $this->assertEquals(
            $order->merchantOrderId("NEW_MERCHANT_ORDER_ID")->toString(),
            "NEW_MERCHANT_ORDER_ID"
        );

        $this->assertEquals(
            $order->currency("EUR")->toString(),
            "EUR"
        );

        $this->assertEquals(
            $order->amount(9999)->toInteger(),
            9999
        );

        $this->assertEquals(
            $order->expirationPeriod("P0Y0M0DT2H0M0S")->format('P%yY%mM%dDT%hH%iM%sS'),
            "P0Y0M0DT2H0M0S"
        );

        $this->assertEquals(
            $order->description("New Order Description")->toString(),
            "New Order Description"
        );

        $this->assertEquals(
            $order->returnUrl("http://www.example.com/API")->toString(),
            "http://www.example.com/API"
        );

        $this->assertEquals(
            $order->toArray(),
            $updatedOrder
        );
    }
}
