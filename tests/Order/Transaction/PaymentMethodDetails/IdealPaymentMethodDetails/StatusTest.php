<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\Status;

final class StatusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\Status',
            Status::fromString('completed')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Status::fromString('');
    }
}
