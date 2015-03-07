<?php

namespace GingerPayments\Payment\Tests\Order\Transaction;

use GingerPayments\Payment\Order\Transaction\Description;

final class DescriptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\Description',
            Description::fromString('My transaction')
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
