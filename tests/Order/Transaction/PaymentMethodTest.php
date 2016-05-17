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
        $this->assertFalse($paymentMethod->isBankTransfer());
    }

    /**
     * @test
     */
    public function itShouldBeCreditCard()
    {
        $paymentMethod = PaymentMethod::fromString(PaymentMethod::CREDIT_CARD);

        $this->assertTrue($paymentMethod->isCreditCard());
        $this->assertFalse($paymentMethod->isIdeal());
        $this->assertFalse($paymentMethod->isBankTransfer());
    }

    /**
     * @test
     */
    public function itShouldBeBankTransfer()
    {
        $paymentMethod = PaymentMethod::fromString(PaymentMethod::BANK_TRANSFER);

        $this->assertTrue($paymentMethod->isBankTransfer());
        $this->assertFalse($paymentMethod->isIdeal());
        $this->assertFalse($paymentMethod->isCreditCard());
    }
}
