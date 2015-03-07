<?php

namespace GingerPayments\Payment\Tests\Order\Transaction;

use GingerPayments\Payment\Order\Transaction\Reason;

final class ReasonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\Reason',
            Reason::fromString('Issuer is non responsive')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Reason::fromString('');
    }
}
