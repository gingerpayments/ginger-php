<?php

namespace GingerPayments\Payment;

use GingerPayments\Payment\HttpClient\CurlHttpClient;

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
     * @return ApiClient
     */
    public static function createClient($endpoint, $apiKey)
    {
        return new ApiClient(
            new CurlHttpClient($endpoint . '/' . self::API_VERSION, $apiKey)
        );
    }
}
