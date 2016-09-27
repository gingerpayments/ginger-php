<?php

namespace GingerPayments\Payment\Tests\Order\Extra;

use GingerPayments\Payment\Order\Extra\Plugin;

final class PluginTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Extra\Plugin',
            Plugin::fromString('Ginger WooCommerce v1.2')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(Plugin::fromString('')->toString());
    }
}
