<?php

namespace Ginger\ApiClient;

final class JsonDecodeFailure extends \RuntimeException
{
    /**
     * @param string $errorMessage
     * @return JsonDecodeFailure
     */
    public static function because($errorMessage)
    {
        return new JsonDecodeFailure(
            sprintf('Failed to decode response: %s', $errorMessage)
        );
    }
}
