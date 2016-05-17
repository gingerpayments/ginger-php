<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\Country;

final class CountryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidCountry()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\Country',
            Country::fromString('NL')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstInvalidCountry()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Country::fromString('NLD');
    }

    /**
     * @test
     */
    public function itShouldNotValidateEmptyString()
    {
        $this->assertEmpty(Country::fromString('')->toString());
    }
}
