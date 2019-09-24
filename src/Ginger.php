<?php

namespace Ginger;

use Ginger\HttpClient\CurlHttpClient;

final class Ginger
{
    /**
     * The library version.
     */
    const CLIENT_VERSION = '2.0.0';

    /**
     * The API version.
     */
    const API_VERSION = 'v1';

    /**
     * Create a new API client.
     *
     * @param string $endpoint
     * @param string $apiKey
     * @param array $defaultCurlOptions
     * @param array $defaultHeaders
     * @return ApiClient
     */
    public static function createClient($endpoint, $apiKey, array $defaultCurlOptions = [], array $defaultHeaders = [])
    {
        return new ApiClient(
            new CurlHttpClient(
                $endpoint . '/' . self::API_VERSION,
                $apiKey,
                array_merge(
                    $defaultHeaders,
                    [
                        'User-Agent' => sprintf(
                            'Ginger-PHP/%s (%s; PHP %s)',
                            self::CLIENT_VERSION,
                            PHP_OS,
                            phpversion()
                        )
                    ]
                ),
                $defaultCurlOptions
            )
        );
    }
}
