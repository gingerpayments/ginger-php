<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\MerchantOrderId;

final class MerchantOrderIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\MerchantOrderId',
            MerchantOrderId::fromString('my-id-1234')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        MerchantOrderId::fromString('');
    }
}
