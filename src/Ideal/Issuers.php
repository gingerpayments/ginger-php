<?php

namespace GingerPayments\Payment\Ideal;

use Assert\Assertion as Guard;

final class Issuers implements \Iterator
{
    /**
     * @var Issuer[]
     */
    private $issuers;

    /**
     * @return Issuers
     */
    public static function create()
    {
        return new Issuers([]);
    }

    /**
     * @param array $issuers
     * @return Issuers
     */
    public static function fromArray(array $issuers)
    {
        return new Issuers(
            array_map(
                function ($issuer) {
                    return Issuer::fromArray($issuer);
                },
                $issuers
            )
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(
            function (Issuer $issuer) {
                return $issuer->toArray();
            },
            $this->issuers
        );
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->issuers);
    }

    public function next()
    {
        return next($this->issuers);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->issuers);
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        $key = key($this->issuers);
        return ($key !== null && $key !== false);
    }

    public function rewind()
    {
        reset($this->issuers);
    }

    /**
     * @param Issuer[] $issuers
     */
    private function __construct(array $issuers = [])
    {
        Guard::allIsInstanceOf($issuers, 'GingerPayments\Payment\Ideal\Issuer');

        $this->issuers = $issuers;
    }
}
