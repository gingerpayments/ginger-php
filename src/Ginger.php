<?php

namespace GingerPayments\Payment;

use GuzzleHttp\Client as HttpClient;

final class Ginger
{
    /**
     * The library version.
     */
    const CLIENT_VERSION = '0.1.0';

    /**
     * The API version.
     */
    const API_VERSION = 'v1';

    /**
     * API endpoint
     */
    const ENDPOINT = 'https://api.gingerpayments.com/{version}/';

    /**
     * Create a new API client.
     *
     * @param string $apiKey Your API key.
     * @return Client
     */
    public static function createClient($apiKey)
    {
        return new Client(
            new HttpClient(
                [
                    'base_url' => [self::ENDPOINT, ['version' => self::API_VERSION]],
                    'defaults' => [
                        'headers' => [
                            'User-Agent' => 'ginger-php/' . self::CLIENT_VERSION,
                            'X-PHP-Version' => PHP_VERSION
                        ],
                        'auth' => [$apiKey, '']
                    ]
                ]
            )
        );
    }
}
