<?php


namespace GingerPayments\Payment;

use GingerPayments\Payment\HttpClient\HttpException;

final class CurlHttpClient implements HttpClient
{
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
            CURLOPT_URL => $path,
            CURLOPT_CUSTOMREQUEST => $method
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
