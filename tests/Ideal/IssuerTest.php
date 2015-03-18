<?php

namespace GingerPayments\Payment\Tests\Ideal;

use GingerPayments\Payment\Ideal\Issuer;

final class IssuerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromAnArray()
    {
        $array = [
            'id' => 'ABNANL2A',
            'name' => 'ABN AMRO Bank',
            'list_type' => 'Nederland'
        ];

        $issuer = Issuer::fromArray($array);

        $this->assertInstanceOf(
            'GingerPayments\Payment\Ideal\Issuer',
            $issuer
        );

        $this->assertEquals($array['id'], (string) $issuer->id());
        $this->assertEquals($array['name'], (string) $issuer->name());
        $this->assertEquals($array['list_type'], (string) $issuer->listType());
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingId()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Issuer::fromArray([]);
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingName()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Issuer::fromArray(['id' => 'ABNANL2A']);
    }

    /**
     * @test
     */
    public function itShouldGuardAgainstMissingListType()
    {
        $this->setExpectedException('Assert\InvalidArgumentException');
        Issuer::fromArray(['id' => 'ABNANL2A', 'name' => 'ABN AMRO']);
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
            'id' => 'ABNANL2A',
            'name' => 'ABN AMRO',
            'list_type' => 'Nederland'
        ];

        $this->assertEquals(
            $array,
            Issuer::fromArray($array)->toArray()
        );
    }
}
