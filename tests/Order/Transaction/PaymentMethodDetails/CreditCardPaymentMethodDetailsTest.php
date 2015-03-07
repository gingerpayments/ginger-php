<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\CreditCardPaymentMethodDetails;

final class CreditCardPaymentMethodDetailsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromAnArray()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\CreditCardPaymentMethodDetails',
            CreditCardPaymentMethodDetails::fromArray(array())
        );
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $this->assertEquals(
            array(),
            CreditCardPaymentMethodDetails::fromArray(array())->toArray()
        );
    }
}
