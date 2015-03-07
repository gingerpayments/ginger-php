<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\Url;

final class UrlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidString()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Url',
            Url::fromString('http://www.google.com')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstAnInvalidUrl()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Url::fromString('very-invalid');
    }
}
