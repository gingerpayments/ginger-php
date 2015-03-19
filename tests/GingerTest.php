<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\Ginger;

final class GingerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateAClient()
    {
        $reflectionClass = new \ReflectionClass('GingerPayments\Payment\Client');
        $reflectionProperty = $reflectionClass->getProperty('httpClient');
        $reflectionProperty->setAccessible(true);

        $client = Ginger::createClient('my-api-key');

        /** @var \GuzzleHttp\Client $httpClient */
        $httpClient = $reflectionProperty->getValue($client);
        $this->assertEquals(
            str_replace('{version}', Ginger::API_VERSION, Ginger::ENDPOINT),
            $httpClient->getBaseUrl()
        );
        $this->assertEquals(
            [
                'User-Agent' =>  'ginger-php/' . Ginger::CLIENT_VERSION,
                'X-PHP-Version' =>  PHP_VERSION
            ],
            $httpClient->getDefaultOption('headers')
        );
        $this->assertEquals(
            ['my-api-key', ''],
            $httpClient->getDefaultOption('auth')
        );

    }
}
