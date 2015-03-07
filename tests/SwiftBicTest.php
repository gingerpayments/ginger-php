<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\SwiftBic;

final class SwiftBicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\SwiftBic',
            SwiftBic::fromString('ABNANL2A')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstInvalidSwiftCode()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        SwiftBic::fromString('very-invalid-code');
    }
}
