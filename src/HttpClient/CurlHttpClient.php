<?php


namespace GingerPayments\Payment\HttpClient;

use GingerPayments\Payment\HttpClient\HttpClient;

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
     * @param string $endpoint
     * @param string $apiKey
     */
    public function __construct($endpoint, $apiKey)
    {
        $this->endpoint = $endpoint;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $method HTTP method
     * @param string $path
     * @param array $headers
     * @param string $data
     * @return string
     * @throws HttpException
     */
    public function request($method, $path, array $headers = [], $data = null)
    {
        $options = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->endpoint . $path,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_USERPWD => $this->apiKey . ':'
        ];

        if ($data != null) {
            $options[CURLOPT_POSTFIELDS] = $data;
            $headers = array_merge(['Content-Length' => strlen($data)], $headers);
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

        return $response;
    }
}
