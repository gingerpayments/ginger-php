<?php

namespace GingerPayments\Payment\Tests\Order;

use GingerPayments\Payment\Order\Extra;

final class ExtraTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromAndToArray()
    {
        $array = [
            'plugin' => 'Ginger WooCommerce v1.2',
            'other_info' => [],
            'dummy'
        ];

        $extra = Extra::fromArray($array);

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Extra',
            $extra
        );

        $this->assertEquals($array, $extra->extra());

        $this->assertEquals(
            $array,
            Extra::fromArray($array)->toArray()
        );
    }
}
