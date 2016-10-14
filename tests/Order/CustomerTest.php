<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Customer;

final class CustomerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromArray()
    {
        $array = [
            'merchant_customer_id' => '123',
            'email_address' => 'email@example.com',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'address_type' => 'customer',
            'address' => 'Radarweg',
            'postal_code' => '1043 NX',
            'housenumber' => '29 A-12',
            'country' => 'NL',
            'phone_numbers' => [],
            'locale' => null
        ];

        $customer = Customer::fromArray($array);

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer',
            $customer
        );

        $this->assertEquals($array['merchant_customer_id'], (string) $customer->merchantCustomerId());
        $this->assertEquals($array['email_address'], $customer->emailAddress());
        $this->assertEquals($array['first_name'], (string) $customer->firstName());
        $this->assertEquals($array['last_name'], (string) $customer->lastName());
        $this->assertEquals($array['address_type'], (string) $customer->addressType());
        $this->assertEquals($array['address'], (string) $customer->address());
        $this->assertEquals($array['postal_code'], (string) $customer->postalCode());
        $this->assertEquals($array['housenumber'], (string) $customer->housenumber());
        $this->assertEquals($array['country'], (string) $customer->country());
        $this->assertEquals($array['phone_numbers'], $customer->phoneNumbers()->toArray());
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
            'merchant_customer_id' => '123',
            'email_address' => 'email@example.com',
            'first_name' => 'Firstname',
            'last_name' => 'Lastname',
            'address_type' => 'customer',
            'address' => 'Radarweg',
            'postal_code' => '1043 NX',
            'housenumber' => '29 A-12',
            'country' => 'NL',
            'phone_numbers' => [],
            'locale' => null
        ];

        $this->assertEquals(
            $array,
            Customer::fromArray($array)->toArray()
        );
    }

    /**
     * @test
     */
    public function itShouldSetMissingValuesToNull()
    {
        $customer = Customer::fromArray([]);

        $this->assertNull($customer->merchantCustomerId());
        $this->assertNull($customer->emailAddress());
        $this->assertNull($customer->firstName());
        $this->assertNull($customer->lastName());
        $this->assertNull($customer->addressType());
        $this->assertNull($customer->address());
        $this->assertNull($customer->postalCode());
        $this->assertNull($customer->housenumber());
        $this->assertNull($customer->country());
        $this->assertNull($customer->phoneNumbers());
    }
}
