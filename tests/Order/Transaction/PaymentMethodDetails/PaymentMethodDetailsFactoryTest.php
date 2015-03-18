<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethod;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\PaymentMethodDetailsFactory;

final class PaymentMethodDetailsFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateAnIdealPaymentMethodDetails()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails',
            PaymentMethodDetailsFactory::createFromArray(
                PaymentMethod::fromString(PaymentMethod::IDEAL),
                ['issuer_id' => 'ABNANL2A']
            )
        );
    }

    /**
     * @test
     */
    public function itShouldCreateACreditCardPaymentMethodDetails()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\CreditCardPaymentMethodDetails',
            PaymentMethodDetailsFactory::createFromArray(
                PaymentMethod::fromString(PaymentMethod::CREDIT_CARD),
                []
            )
        );
    }

    /**
     * @test
     */
    public function itShouldFailWhenAnUnsupportedPaymentMethodIsProvided()
    {
        $paymentMethod = PaymentMethod::fromString(PaymentMethod::IDEAL);

        $reflectionClass = new \ReflectionClass('GingerPayments\Payment\Order\Transaction\PaymentMethod');
        $reflectionProperty = $reflectionClass->getProperty('value');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($paymentMethod, 'very-unsupported-method');

        $this->setExpectedException('InvalidArgumentException');
        PaymentMethodDetailsFactory::createFromArray($paymentMethod, []);
    }
}
