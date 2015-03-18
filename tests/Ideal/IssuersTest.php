<?php

namespace GingerPayments\Payment\Tests\Ideal;

use GingerPayments\Payment\Ideal\Issuers;

final class IssuersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreate()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Ideal\Issuers',
            Issuers::create()
        );
    }

    /**
     * @test
     */
    public function itShouldCreateFromArray()
    {
        $array = [
            [
                'id' => 'ABNANL2A',
                'name' => 'ABN AMRO Bank',
                'list_type' => 'Nederland'
            ]
        ];

        $issuers = Issuers::fromArray($array);
        $this->assertInstanceOf(
            'GingerPayments\Payment\Ideal\Issuers',
            $issuers
        );
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $array = [
            [
                'id' => 'ABNANL2A',
                'name' => 'ABN AMRO Bank',
                'list_type' => 'Nederland'
            ]
        ];

        $this->assertEquals(
            $array,
            Issuers::fromArray($array)->toArray()
        );
    }

    /**
     * @test
     */
    public function itShouldBeTraversable()
    {
        $array = [
            [
                'id' => 'ABNANL2A',
                'name' => 'ABN AMRO Bank',
                'list_type' => 'Nederland'
            ],
            [
                'id' => 'INGBNL2A',
                'name' => 'ING Bank',
                'list_type' => 'Nederland'
            ]
        ];

        $issuers = Issuers::fromArray($array);
        $iterations = 0;
        foreach ($issuers as $key => $issuer) {
            $this->assertEquals($iterations, $key);
            $this->assertInstanceOf('GingerPayments\Payment\Ideal\Issuer', $issuer);
            $iterations++;
        }
        $this->assertEquals(2, $iterations);
    }
}
