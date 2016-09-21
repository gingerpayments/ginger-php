<?php

namespace GingerPayments\Payment\Tests;

final class HelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldGetValidModulus()
    {
        $this->assertEquals(bcmod("7044060001970316212900", 150), "50");
    }
}
