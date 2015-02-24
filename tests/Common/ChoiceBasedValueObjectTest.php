<?php

namespace GingerPayments\Payment\Tests\Common;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class ChoiceBasedValueObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldAcceptValidChoices()
    {
        foreach (array('foo', 'bar', 'baz') as $choice) {
            $choiceValueObject = FakeChoiceBasedValueObject::create($choice);
            $this->assertInstanceOf(
                'GingerPayments\Payment\Tests\Common\FakeChoiceBasedValueObject',
                $choiceValueObject
            );
        }
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstInvalidChoices()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        FakeChoiceBasedValueObject::create('invalid');
    }
}

final class FakeChoiceBasedValueObject
{
    use ChoiceBasedValueObject;

    public static function create($value)
    {
        return new FakeChoiceBasedValueObject($value);
    }

    public function possibleValues()
    {
        return array('foo', 'bar', 'baz');
    }
}
