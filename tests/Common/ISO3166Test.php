<?php

namespace GingerPayments\Payment\Tests\Common;

use GingerPayments\Payment\Common\ISO3166;

final class ISO3166Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldBeValidISO3166Country()
    {
        $this->assertTrue(ISO3166::isValid('NL'));
        $this->assertFalse(ISO3166::isValid('NLD'));
    }
}
