<?php

namespace Ginger\ApiClient;

final class ServerError extends \RuntimeException
{
    /**
     * @param array $result
     * @return ServerError
     */
    public static function fromResult(array $result)
    {
        return new ServerError(
            sprintf(
                '%s(%s): %s',
                $result['error']['type'],
                $result['error']['status'],
                $result['error']['value']
            )
        );
    }
}
