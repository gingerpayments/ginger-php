<?php

namespace GingerPayments\Payment\Tests\Mock;

use GingerPayments\Payment\Common\StringBasedValueObject;

final class FakeStringBasedValueObject
{
    use StringBasedValueObject;

    private function __construct($value)
    {
        $this->value = $value;
    }
}
