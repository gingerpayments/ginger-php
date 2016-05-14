<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\AddressType;

final class AddressTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeBilling()
    {
        $addressType = AddressType::fromString(AddressType::BILLING);

        $this->assertTrue($addressType->isBilling());

        $this->assertFalse($addressType->isCustomer());
        $this->assertFalse($addressType->isDelivery());
    }

    /**
     * @test
     */
    public function itShouldBeCustomer()
    {
        $addressType = AddressType::fromString(AddressType::CUSTOMER);

        $this->assertTrue($addressType->isCustomer());

        $this->assertFalse($addressType->isBilling());
        $this->assertFalse($addressType->isDelivery());
    }

    /**
     * @test
     */
    public function itShouldBeDelivery()
    {
        $addressType = AddressType::fromString(AddressType::DELIVERY);

        $this->assertTrue($addressType->isDelivery());

        $this->assertFalse($addressType->isCustomer());
        $this->assertFalse($addressType->isBilling());
    }
}
