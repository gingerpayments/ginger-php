<?php

namespace Ginger\HttpClient;

final class CurlHttpClient implements HttpClient
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var array
     */
    private $defaultHeaders;

    /**
     * @var array
     */
    private $defaultCurlOptions;

    /**
     * @param string $endpoint
     * @param string $apiKey
     * @param array $defaultHeaders
     * @param array $defaultCurlOptions
     */
    public function __construct($endpoint, $apiKey, array $defaultHeaders = [], array $defaultCurlOptions = [])
    {
        $this->endpoint = $endpoint;
        $this->apiKey = $apiKey;
        $this->defaultHeaders = $defaultHeaders;
        $this->defaultCurlOptions = $defaultCurlOptions;
    }

    /**
     * @param string $method HTTP method
     * @param string $path
     * @param array $headers
     * @param string $data
     * @return string|null
     * @throws HttpException
     */
    public function request($method, $path, array $headers = [], $data = null)
    {
        $options = $this->defaultCurlOptions;
        $options[CURLOPT_RETURNTRANSFER] = 1;
        $options[CURLOPT_URL] = $this->endpoint . $path;
        $options[CURLOPT_CUSTOMREQUEST] = $method;
        $options[CURLOPT_USERPWD] = $this->apiKey . ':';

        $headers = array_merge($this->defaultHeaders, $headers);
        if ($data != null) {
            $options[CURLOPT_POSTFIELDS] = $data;
            $headers = array_merge(
                ['Content-Length' => strlen($data)],
                $headers
            );
        }

        if (!empty($headers)) {
            $options[CURLOPT_HTTPHEADER] = array_map(
                function($key, $value) { return "$key: $value"; },
                array_keys($headers),
                $headers
            );
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $errorNumber = curl_errno($curl);
        $errorMessage = curl_error($curl);
        curl_close($curl);

        if ($errorNumber) {
            throw new HttpException(
                sprintf(
                    'cURL error: %s: %s (%s) for %s',
                    $errorNumber,
                    $errorMessage,
                    'see https://curl.haxx.se/libcurl/c/libcurl-errors.html',
                    $path
                )
            );
        }

        if ($response === true || $response == '') {
            return null;
        }

        return $response;
    }
}
