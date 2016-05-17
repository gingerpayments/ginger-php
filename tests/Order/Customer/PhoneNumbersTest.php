<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\PhoneNumbers;

final class PhoneNumbersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreate()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\PhoneNumbers',
            PhoneNumbers::create()
        );
    }

    /**
     * @test
     */
    public function itShouldCreateFromArray()
    {
        $array = [
            '+31 (0) 6123 45678',
            '+372 6123 45678'
        ];

        $phoneNumbers = PhoneNumbers::fromArray($array);

        $this->assertInstanceOf(

            'GingerPayments\Payment\Order\Customer\PhoneNumbers',
            $phoneNumbers
        );
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
            '+31 (0) 6123 45678',
            '+372 6123 45678'
        ];

        $this->assertEquals(
            $array,
            PhoneNumbers::fromArray($array)->toArray()
        );
    }

    /**
     * @test
     */
    public function itShouldBeTraversable()
    {
        $array = [
            '+31 (0) 6123 45678',
            '+372 6123 45678'
        ];

        $phoneNumbers = PhoneNumbers::fromArray($array);
        $iterations = 0;
        foreach ($phoneNumbers as $key => $phoneNumber) {
            $this->assertEquals($iterations, $key);
            $this->assertInstanceOf('GingerPayments\Payment\Order\Customer\PhoneNumber', $phoneNumber);
            $iterations++;
        }

        $this->assertEquals(2, $iterations);
    }
}
