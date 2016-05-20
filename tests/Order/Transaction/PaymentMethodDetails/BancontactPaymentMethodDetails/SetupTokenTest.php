<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails\SetupToken;

final class SetupTokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails\SetupToken',
            SetupToken::fromString('1234-5678-9123-4567')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(SetupToken::fromString('')->toString());
    }
}
