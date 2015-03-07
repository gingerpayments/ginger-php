<?php

namespace GingerPayments\Payment\Tests\Order\Transaction;

use GingerPayments\Payment\Order\Transaction\Amount;

final class AmountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidInteger()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\Amount',
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
