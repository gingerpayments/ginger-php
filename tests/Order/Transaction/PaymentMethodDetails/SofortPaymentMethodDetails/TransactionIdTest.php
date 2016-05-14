<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails\SofortPaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\SofortPaymentMethodDetails\TransactionId;

final class TransactionIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\SofortPaymentMethodDetails\TransactionId',
            TransactionId::fromString('DFGHDFGIFGJERGOWJ21')
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
