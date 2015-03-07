<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\Iban;

final class IbanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Iban',
            Iban::fromString('NL45ABNA0605584621')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstInvalidIban()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Iban::fromString('NL12IGNB0123467890');
    }
}
