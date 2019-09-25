<?php

namespace Ginger\HttpClient;

/**
 * Custom HTTP interface because we do not want to depend on too many external
 * packages.
 */
interface HttpClient
{
    /**
     * @param string $method HTTP method
     * @param string $path
     * @param array $headers
     * @param string $data
     * @return string|null
     * @throws HttpException
     */
    public function request($method, $path, array $headers = [], $data = null);
}
