<?php

namespace GingerPayments\Payment\Ideal;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Ideal\Issuer\ListType;
use GingerPayments\Payment\Ideal\Issuer\Name;
use GingerPayments\Payment\SwiftBic;

final class Issuer
{
    /**
     * @var SwiftBic
     */
    private $id;

    /**
     * @var Name
     */
    private $name;

    /**
     * @var ListType
     */
    private $listType;

    /**
     * @param array $array
     * @return Issuer
     */
    public static function fromArray(array $array)
    {
        Guard::keyExists($array, 'id');
        Guard::keyExists($array, 'name');
        Guard::keyExists($array, 'list_type');

        return new Issuer(
            SwiftBic::fromString($array['id']),
            Name::fromString($array['name']),
            ListType::fromString($array['list_type'])
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id()->toString(),
            'name' => $this->name()->toString(),
            'list_type' => $this->listType()->toString()
        ];
    }

    /**
     * @return SwiftBic
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return ListType
     */
    public function listType()
    {
        return $this->listType;
    }

    /**
     * @param SwiftBic $id
     * @param Name $name
     * @param ListType $listType
     */
    private function __construct(SwiftBic $id, Name $name, ListType $listType)
    {
        $this->id = $id;
        $this->name = $name;
        $this->listType = $listType;
    }
}
