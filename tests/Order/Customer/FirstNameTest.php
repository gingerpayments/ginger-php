<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\FirstName;

final class FirstNameTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\FirstName',
            FirstName::fromString('Firstname')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(FirstName::fromString('')->toString());
    }
}
