<?php

namespace GingerPayments\Payment\Tests\Order\Transaction;

use GingerPayments\Payment\Order\Transaction\Balance;

final class BalanceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeInternal()
    {
        $balance = Balance::fromString(Balance::INTERNAL);

        $this->assertTrue($balance->isInternal());
        $this->assertFalse($balance->isExternal());
        $this->assertFalse($balance->isTest());
    }

    /**
     * @test
     */
    public function itShouldBeExternal()
    {
        $balance = Balance::fromString(Balance::EXTERNAL);

        $this->assertFalse($balance->isInternal());
        $this->assertTrue($balance->isExternal());
        $this->assertFalse($balance->isTest());
    }

    /**
     * @test
     */
    public function itShouldBeTest()
    {
        $balance = Balance::fromString(Balance::TEST);

        $this->assertFalse($balance->isInternal());
        $this->assertFalse($balance->isExternal());
        $this->assertTrue($balance->isTest());
    }
}
