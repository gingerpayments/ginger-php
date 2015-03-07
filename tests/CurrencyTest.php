<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\Currency;

final class CurrencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Currency',
            Currency::fromString('EUR')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstInvalidCurrency()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Currency::fromString('USD');
    }
}
