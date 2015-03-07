<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Description;

final class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Description',
            Description::fromString('My order')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Description::fromString('');
    }
}
