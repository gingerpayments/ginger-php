<?php

namespace Ginger\Tests;

use Ginger\ApiClient;
use Ginger\Ginger;

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
