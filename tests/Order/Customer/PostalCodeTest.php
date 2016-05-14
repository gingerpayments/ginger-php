<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\PostalCode;

final class PostalCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\PostalCode',
            PostalCode::fromString('1043 NX')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(PostalCode::fromString('')->toString());
    }
}
