<?php

namespace Ginger;

use Ginger\ApiClient\HttpRequestFailure;
use Ginger\ApiClient\JsonDecodeFailure;
use Ginger\ApiClient\ServerError;
use Ginger\HttpClient\HttpClient;

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
        return $this->send('GET', '/ideal/issuers');
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
        return $this->send('GET', sprintf('/orders/%s', $id));
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
        return $this->send('POST', '/orders', $orderData);
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
        return $this->send('PUT', sprintf('/orders/%s', $id), $orderData);
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
        return $this->send('POST', sprintf('/orders/%s/refunds', $id), $orderData);
    }

    /**
     * Capture an order transaction.
     *
     * @param string $orderId The ID of the order.
     * @param string $transactionId The ID of the transaction to capture.
     * @return void
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function captureOrderTransaction($orderId, $transactionId)
    {
        $this->send('POST', sprintf('/orders/%s/transactions/%s/captures/', $orderId, $transactionId));
    }

    /**
     * Get an array of the available currency for every payment method.
     *
     * @return array The list of available currency.
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function getCurrencyList(){
        return $this->send('GET','/merchants/self/projects/self/currencies');
    }

    /**
     * Send a request to the API.
     *
     * @param string $method HTTP request method
     * @param string $path URL path to call
     * @param mixed $data Request data to send
     * @return array
     * @throws HttpRequestFailure When an error occurred while processing the request.
     * @throws JsonDecodeFailure When the response data could not be decoded.
     */
    public function send($method, $path, $data = null)
    {
        try {
            $response = $this->httpClient->request(
                $method,
                $path,
                !is_null($data) ? ['Content-Type' => 'application/json'] : [],
                !is_null($data) ? json_encode($data) : null
            );
        } catch (\Exception $exception) {
            throw HttpRequestFailure::because($exception);
        }

        return $this->interpretResponse($response);
    }

    /**
     * @param string|null $response
     * @return array|null
     * @throws JsonDecodeFailure
     * @throws ServerError
     */
    private function interpretResponse($response)
    {
        if ($response === null) {
            return null;
        }

        $result = $this->decodeJson($response);
        if (array_key_exists('error', $result)) {
            throw ServerError::fromResult($result);
        }
        return $result;
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
