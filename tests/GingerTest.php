<?php

namespace Ginger\Tests;

use Ginger\ApiClient;
use Ginger\Ginger;
use PHPUnit\Framework\TestCase;

final class GingerTest extends TestCase
{
    public function test_it_creates_a_client()
    {
        $this->assertInstanceOf(
            ApiClient::class,
            Ginger::createClient('https://www.example.com', 'abc123')
        );
    }
}
