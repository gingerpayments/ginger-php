<?php

namespace GingerPayments\Payment\Tests\Common;

use GingerPayments\Payment\Tests\Mock\FakeChoiceBasedValueObject;

final class ChoiceBasedValueObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldAcceptValidChoices()
    {
        foreach (['foo', 'bar', 'baz'] as $choice) {
            $choiceValueObject = FakeChoiceBasedValueObject::create($choice);
            $this->assertInstanceOf(
                'GingerPayments\Payment\Tests\Mock\FakeChoiceBasedValueObject',
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
