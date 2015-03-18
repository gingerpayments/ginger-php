<?php

namespace GingerPayments\Payment\Tests\Ideal\Issuer;

use GingerPayments\Payment\Ideal\Issuer\ListType;

final class ListTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Ideal\Issuer\ListType',
            ListType::fromString('ABN AMRO')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstEmptyValue()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        ListType::fromString('');
    }
}
