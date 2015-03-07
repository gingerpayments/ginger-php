<?php

namespace GingerPayments\Payment\Tests\Order\Transaction;

use GingerPayments\Payment\Order\Transaction\PaymentMethod;

final class PaymentMethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeIdeal()
    {
        $paymentMethod = PaymentMethod::fromString(PaymentMethod::IDEAL);

        $this->assertTrue($paymentMethod->isIdeal());
        $this->assertFalse($paymentMethod->isCreditCard());
    }

    /**
     * @test
     */
    public function itShouldBeCreditCard()
    {
        $paymentMethod = PaymentMethod::fromString(PaymentMethod::CREDIT_CARD);

        $this->assertFalse($paymentMethod->isIdeal());
        $this->assertTrue($paymentMethod->isCreditCard());
    }
}
