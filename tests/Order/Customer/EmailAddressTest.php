<?php

namespace GingerPayments\Payment\Tests\Order\Customer;

use GingerPayments\Payment\Order\Customer\EmailAddress;

final class EmailAddressTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldInstantiateFromAValidEmail()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Customer\EmailAddress',
            EmailAddress::fromString('email@example.com')
        );
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstAnInvalidEmail()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        EmailAddress::fromString('email.example.com');
    }

    /**
     * @test
     */
    public function itShouldNotValidateEmptyString()
    {
        $this->assertEmpty(EmailAddress::fromString('')->toString());
    }
}
