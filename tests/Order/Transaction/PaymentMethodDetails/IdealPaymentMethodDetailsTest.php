<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

final class IdealPaymentMethodDetailsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromAnArray()
    {
        $paymentDetails = IdealPaymentMethodDetails::fromArray(
            array(
                'issuer_id' => 'ABNANL2A',
                'status' => 'completed',
                'transaction_id' => 'some-unique-id-abc123',
                'consumer_name' => 'FA de Vries',
                'consumer_city' => 'Amsterdam',
                'consumer_iban' => 'NL91ABNA0417164300',
                'consumer_bic' => 'ABNANL2A'
            )
        );

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails',
            $paymentDetails
        );

        $this->assertEquals('ABNANL2A', (string) $paymentDetails->issuerId());
        $this->assertEquals('completed', (string) $paymentDetails->status());
        $this->assertEquals('some-unique-id-abc123', (string) $paymentDetails->transactionId());
        $this->assertEquals('FA de Vries', (string) $paymentDetails->consumerName());
        $this->assertEquals('Amsterdam', (string) $paymentDetails->consumerCity());
        $this->assertEquals('NL91ABNA0417164300', (string) $paymentDetails->consumerIban());
        $this->assertEquals('ABNANL2A', (string) $paymentDetails->consumerBic());
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingIssuerId()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        IdealPaymentMethodDetails::fromArray(array());
    }

    /**
     * @test
     */
    public function itShouldSetMissingValuesToNull()
    {
        $paymentDetails = IdealPaymentMethodDetails::fromArray(
            array(
                'issuer_id' => 'ABNANL2A'
            )
        );

        $this->assertNull($paymentDetails->status());
        $this->assertNull($paymentDetails->transactionId());
        $this->assertNull($paymentDetails->consumerName());
        $this->assertNull($paymentDetails->consumerCity());
        $this->assertNull($paymentDetails->consumerIban());
        $this->assertNull($paymentDetails->consumerBic());
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = array(
            'issuer_id' => 'ABNANL2A',
            'status' => 'completed',
            'transaction_id' => 'some-unique-id-abc123',
            'consumer_name' => 'FA de Vries',
            'consumer_city' => 'Amsterdam',
            'consumer_iban' => 'NL91ABNA0417164300',
            'consumer_bic' => 'ABNANL2A'
        );

        $this->assertEquals(
            $array,
            IdealPaymentMethodDetails::fromArray($array)->toArray()
        );
    }
}
