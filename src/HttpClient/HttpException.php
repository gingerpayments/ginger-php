<?php

namespace Ginger\HttpClient;

final class HttpException extends \RuntimeException
{
    /**
     * @param int $errorNumber
     * @param string $errorMessage
     * @param string $path
     * @return HttpException
     */
    public static function because($errorNumber, $errorMessage, $path)
    {
        return new HttpException(
            sprintf(
                'cURL error: %s: %s (%s) for %s',
                $errorNumber,
                $errorMessage,
                'see https://curl.haxx.se/libcurl/c/libcurl-errors.html',
                $path
            )
        );
    }
}
