<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCity;

final class ConsumerCityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCity',
            ConsumerCity::fromString('Amsterdam')
        );
    }
}
