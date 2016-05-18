<?php

namespace GingerPayments\Payment\Order\Customer;

use Assert\Assertion as Guard;

final class PhoneNumbers implements \Iterator
{
    /**
     * @var PhoneNumbers[]
     */
    private $phoneNumbers;

    /**
     * @return PhoneNumbers
     */
    public static function create()
    {
        return new static([]);
    }

    /**
     * @param array $phoneNumbers
     * @return PhoneNumbers
     */
    public static function fromArray(array $phoneNumbers)
    {
        return new static(
            array_map(
                function ($phoneNumber) {
                    return PhoneNumber::fromString($phoneNumber);
                },
                $phoneNumbers
            )
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(
            function (PhoneNumber $phoneNumber) {
                return $phoneNumber->toString();
            },
            $this->phoneNumbers
        );
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->phoneNumbers);
    }

    public function next()
    {
        return next($this->phoneNumbers);
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return key($this->phoneNumbers);
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        $key = key($this->phoneNumbers);
        return ($key !== null && $key !== false);
    }

    public function rewind()
    {
        reset($this->phoneNumbers);
    }

    /**
     * @param array $phoneNumbers
     */
    private function __construct(array $phoneNumbers = [])
    {
        Guard::allIsInstanceOf($phoneNumbers, 'GingerPayments\Payment\Order\Customer\PhoneNumber');

        $this->phoneNumbers = $phoneNumbers;
    }
}
