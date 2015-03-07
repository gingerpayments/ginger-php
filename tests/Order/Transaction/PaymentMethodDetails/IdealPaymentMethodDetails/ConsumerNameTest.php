<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerName;

final class ConsumerNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerName',
            ConsumerName::fromString('FA de Vries')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        ConsumerName::fromString('');
    }
}
