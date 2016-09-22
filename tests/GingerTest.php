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

        $client = Ginger::createClient('f47ac10b58cc4372a5670e02b2c3d479');

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
            ['f47ac10b58cc4372a5670e02b2c3d479', ''],
            $httpClient->getDefaultOption('auth')
        );
    }

    /**
     * @test
     */
    public function itShouldFailWithIncorrectAPIkey()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Ginger::createClient('my-api-key');
    }

    /**
     * @test
     */
    public function itShouldCreateAValidUUD()
    {
        $this->assertEquals(
            Ginger::apiKeyToUuid('f47ac10b58cc4372a5670e02b2c3d479'),
            'f47ac10b-58cc-4372-a567-0e02b2c3d479'
        );
    }
}
