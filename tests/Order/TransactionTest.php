<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Transaction;

final class TransactionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromAnArray()
    {
        $array = [
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
        ];

        $transaction = Transaction::fromArray($array);

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction',
            $transaction
        );

        $this->assertEquals($array['payment_method'], (string) $transaction->paymentMethod());
        $this->assertEquals($array['payment_method_details'], $transaction->paymentMethodDetails()->toArray());
        $this->assertEquals($array['id'], (string) $transaction->id());
        $this->assertEquals($array['created'], $transaction->created()->toIso8601String());
        $this->assertEquals($array['modified'], $transaction->modified()->toIso8601String());
        $this->assertEquals($array['completed'], $transaction->completed()->toIso8601String());
        $this->assertEquals($array['status'], (string) $transaction->status());
        $this->assertEquals($array['reason'], (string) $transaction->reason());
        $this->assertEquals($array['currency'], (string) $transaction->currency());
        $this->assertEquals($array['amount'], $transaction->amount()->toInteger());
        $this->assertEquals(
            $array['expiration_period'],
            $transaction->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
        );
        $this->assertEquals($array['description'], (string) $transaction->description());
        $this->assertEquals($array['balance'], (string) $transaction->balance());
        $this->assertEquals($array['payment_url'], (string) $transaction->paymentUrl());
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingPaymentMethod()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Transaction::fromArray([]);
    }

    /**
     * @test
     */
    public function itShouldSetMissingValuesToNull()
    {
        $transaction = Transaction::fromArray(['payment_method' => 'credit-card']);

        $this->assertEquals([], $transaction->paymentMethodDetails()->toArray());
        $this->assertNull($transaction->id());
        $this->assertNull($transaction->created());
        $this->assertNull($transaction->modified());
        $this->assertNull($transaction->completed());
        $this->assertNull($transaction->status());
        $this->assertNull($transaction->reason());
        $this->assertNull($transaction->currency());
        $this->assertNull($transaction->amount());
        $this->assertNull($transaction->expirationPeriod());
        $this->assertNull($transaction->description());
        $this->assertNull($transaction->balance());
        $this->assertNull($transaction->paymentUrl());
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
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
        ];

        $this->assertEquals(
            $array,
            Transaction::fromArray($array)->toArray()
        );
    }
}
