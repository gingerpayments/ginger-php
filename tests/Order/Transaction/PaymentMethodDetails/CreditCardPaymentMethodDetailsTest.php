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
            CreditCardPaymentMethodDetails::fromArray([])
        );
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $this->assertEquals(
            [],
            CreditCardPaymentMethodDetails::fromArray([])->toArray()
        );
    }
}
