<?php

namespace GingerPayments\Payment\Tests;

final class FallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldGetValidModulus()
    {
        $this->assertEquals(my_bcmod("7044060001970316212900", 150), "50");
    }
}
