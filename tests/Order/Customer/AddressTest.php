<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\Address;

final class AddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\Address',
            Address::fromString('Address string')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(Address::fromString('')->toString());
    }
}
