<?php

namespace GingerPayments\Payment\Tests\Common;

use GingerPayments\Payment\Common\ArrayFunctions;

final class ArrayFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldRemoveNullValues()
    {
        $array = [
            0 => 'foo',
            1 => 'bar',
            2 => null,
            3 => [
                0 => 'foo',
                1 => null,
                2 => 'bar'
            ],
            4 => null,
            5 => []
        ];

        $expected = [
            0 => 'foo',
            1 => 'bar',
            3 => [
                0 => 'foo',
                2 => 'bar'
            ]
        ];

        $this->assertEquals($expected, ArrayFunctions::withoutNullValues($array));
    }
}
