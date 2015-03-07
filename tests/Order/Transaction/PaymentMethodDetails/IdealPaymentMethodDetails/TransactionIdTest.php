<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\TransactionId;

final class TransactionIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\TransactionId',
            TransactionId::fromString('completed')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        TransactionId::fromString('');
    }
}
