<?php

namespace GingerPayments\Payment\Tests\Ideal\Issuer;

use GingerPayments\Payment\Ideal\Issuer\Name;

final class NameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Ideal\Issuer\Name',
            Name::fromString('ABN AMRO')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Name::fromString('');
    }
}
