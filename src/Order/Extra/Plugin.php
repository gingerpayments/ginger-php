<?php

namespace GingerPayments\Payment\Order\Extra;

use GingerPayments\Payment\Common\StringBasedValueObject;

final class Plugin
{
    use StringBasedValueObject;

    /**
     * @param string $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }
}
