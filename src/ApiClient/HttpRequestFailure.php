<?php

namespace Ginger\ApiClient;

final class HttpRequestFailure extends \RuntimeException
{
    /**
     * @param \Exception $exception
     * @return HttpRequestFailure
     */
    public static function because(\Exception $exception)
    {
        return new HttpRequestFailure(
            sprintf('An error occurred while processing the request: %s', $exception->getMessage()),
            $exception->getCode(),
            $exception
        );
    }
}
