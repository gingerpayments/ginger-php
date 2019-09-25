<?php

namespace Ginger\Tests\HttpClient;

use Ginger\HttpClient\HttpClient;
use Ginger\HttpClient\HttpException;

final class MockHttpClient implements HttpClient
{
    /**
     * @var array
     */
    private $lastRequestData = [];

    /**
     * @var string
     */
    private $responseToReturn;

    /**
     * @var HttpException
     */
    private $exceptionToThrow;

    /**
     * @param string $method
     * @param string $path
     * @param array $headers
     * @param string $data
     * @return string|null
     */
    public function request($method, $path, array $headers = [], $data = null)
    {
        $this->lastRequestData = func_get_args();

        if ($this->exceptionToThrow !== null) {
            throw $this->exceptionToThrow;
        }

        return $this->responseToReturn;
    }

    /**
     * @return array
     */
    public function lastRequestData()
    {
        return $this->lastRequestData;
    }

    /**
     * @param string $response
     */
    public function setResponseToReturn($response)
    {
        $this->responseToReturn = $response;
    }

    /**
     * @param HttpException $exception
     */
    public function setExceptionToThrow(HttpException $exception)
    {
        $this->exceptionToThrow = $exception;
    }
}
