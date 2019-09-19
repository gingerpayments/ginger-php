<?php

namespace GingerPayments\Payment;

use GingerPayments\Payment\ApiClient\HttpRequestFailure;
use GingerPayments\Payment\ApiClient\JsonDecodeFailure;
use GingerPayments\Payment\HttpClient\HttpClient;

final class ApiClient
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get an array of possible iDEAL issuers.
     *
     * @return array
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function getIdealIssuers()
    {
        try {
            $response = $this->httpClient->request('GET', '/ideal/issuers');
        } catch (\Exception $exception) {
            throw HttpRequestFailure::because($exception);
        }

        return $this->decodeJson($response);
    }

    /**
     * Get an order.
     *
     * @param string $id The order ID.
     * @return array The order.
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function getOrder($id)
    {
        try {
            $response = $this->httpClient->request('GET', sprintf('/orders/%s', $id));
        } catch (\Exception $exception) {
            throw HttpRequestFailure::because($exception);
        }

        return $this->decodeJson($response);
    }

    /**
     * Create a new order.
     *
     * @param array $orderData
     * @return array The newly created order.
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function createOrder(array $orderData)
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                '/orders',
                ['Content-Type' => 'application/json'],
                json_encode($orderData)
            );
        } catch (\Exception $exception) {
            throw HttpRequestFailure::because($exception);
        }

        return $this->decodeJson($response);
    }

    /**
     * Update an order.
     *
     * @param string $id The ID of the order to update.
     * @param array $orderData Associative array with attributes and values to update.
     * @return array The newly updated order.
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function updateOrder($id, array $orderData)
    {
        try {
            $response = $this->httpClient->request(
                'PUT',
                sprintf('/orders/%s', $id),
                ['Content-Type' => 'application/json'],
                json_encode($orderData)
            );
        } catch (\Exception $exception) {
            throw HttpRequestFailure::because($exception);
        }

        return $this->decodeJson($response);
    }

    /**
     * Refund an order.
     *
     * @param string $id The ID of the order to update.
     * @param array $orderData Refund data.
     * @return array The newly updated order.
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function refundOrder($id, array $orderData)
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                sprintf('/orders/%s/refunds', $id),
                ['Content-Type' => 'application/json'],
                json_encode($orderData)
            );
        } catch (\Exception $exception) {
            throw HttpRequestFailure::because($exception);
        }

        return $this->decodeJson($response);
    }

    /**
     * @param string $response
     * @return array
     * @throws JsonDecodeFailure
     */
    private function decodeJson($response)
    {
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw JsonDecodeFailure::because(json_last_error_msg());
        }
        return $decoded;
    }
}
