<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\MerchantCustomerId;

final class MerchantCustomerIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\MerchantCustomerId',
            MerchantCustomerId::fromString('MT1235')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(MerchantCustomerId::fromString('')->toString());
    }
}
