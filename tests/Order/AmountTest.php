<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Amount;

final class AmountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidInteger()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Amount',
            Amount::fromInteger(1234)
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstNegativeValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Amount::fromInteger(-1);
    }

    /**
     * @test
     */
    public function itShouldConvertToInteger()
    {
        $this->assertEquals(3456, Amount::fromInteger(3456)->toInteger());
    }
}
