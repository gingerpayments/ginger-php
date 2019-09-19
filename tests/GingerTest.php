<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\ApiClient;
use GingerPayments\Payment\Ginger;

final class GingerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_creates_a_client()
    {
        $this->assertInstanceOf(
            ApiClient::class,
            Ginger::createClient('https://www.example.com', 'abc123')
        );
    }
}
