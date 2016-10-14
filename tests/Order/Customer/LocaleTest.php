<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\Locale;

final class LocaleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\Locale',
            Locale::fromString('en_US')
        );

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\Locale',
            Locale::fromString('en')
        );
    }

    /**
     * @test
     */
    public function itCanBeEmptyString()
    {
        $this->assertEmpty(Locale::fromString('')->toString());
    }

    /**
     * @test
     */
    public function itShouldFailOnIncorrectLocale()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Locale::fromString('en_us');

        $this->setExpectedException('Assert\InvalidArgumentException');
        Locale::fromString('eng_US');

        $this->setExpectedException('Assert\InvalidArgumentException');
        Locale::fromString('en_US.UTF-8');
    }
}
