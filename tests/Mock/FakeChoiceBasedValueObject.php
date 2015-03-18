<?php

namespace GingerPayments\Payment\Tests\Mock;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class FakeChoiceBasedValueObject
{
    use ChoiceBasedValueObject;

    public static function create($value)
    {
        return new FakeChoiceBasedValueObject($value);
    }

    public function possibleValues()
    {
        return ['foo', 'bar', 'baz'];
    }
}
