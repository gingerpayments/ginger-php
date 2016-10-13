<?php

namespace GingerPayments\Payment\Order;

use GingerPayments\Payment\Order\Customer\MerchantCustomerId;
use GingerPayments\Payment\Order\Customer\EmailAddress;
use GingerPayments\Payment\Order\Customer\FirstName;
use GingerPayments\Payment\Order\Customer\LastName;
use GingerPayments\Payment\Order\Customer\AddressType;
use GingerPayments\Payment\Order\Customer\Address;
use GingerPayments\Payment\Order\Customer\PostalCode;
use GingerPayments\Payment\Order\Customer\Housenumber;
use GingerPayments\Payment\Order\Customer\Country;
use GingerPayments\Payment\Order\Customer\PhoneNumbers;
use GingerPayments\Payment\Order\Customer\Locale;

final class Customer
{
    /**
     * @var MerchantCustomerId|null
     */
    private $merchantCustomerId;

    /**
     * @var EmailAddress|null
     */
    private $emailAddress;

    /**
     * @var FirstName|null
     */
    private $firstName;

    /**
     * @var LastName|null
     */
    private $lastName;

    /**
     * @var AddressType|null
     */
    private $addressType;

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var PostalCode|null
     */
    private $postalCode;

    /**
     * @var Housenumber|null
     */
    private $housenumber;

    /**
     * @var Country|null
     */
    private $country;

    /**
     * @var PhoneNumbers|null
     */
    private $phoneNumbers;

    /**
     * @var Locale|null
     */
    private $locale;

    /**
     * @param array $details
     * @return Customer
     */
    public static function fromArray(array $details)
    {
        return new static(
            array_key_exists('merchant_customer_id', $details)
                ? MerchantCustomerId::fromString($details['merchant_customer_id']) : null,
            array_key_exists('email_address', $details) ? EmailAddress::fromString($details['email_address']) : null,
            array_key_exists('first_name', $details) ? FirstName::fromString($details['first_name']) : null,
            array_key_exists('last_name', $details) ? LastName::fromString($details['last_name']) : null,
            array_key_exists('address_type', $details) ? AddressType::fromString($details['address_type']) : null,
            array_key_exists('address', $details) ? Address::fromString($details['address']) : null,
            array_key_exists('postal_code', $details) ? PostalCode::fromString($details['postal_code']) : null,
            array_key_exists('housenumber', $details) ? Housenumber::fromString($details['housenumber']) : null,
            array_key_exists('country', $details) ? Country::fromString($details['country']) : null,
            array_key_exists('phone_numbers', $details) ? PhoneNumbers::fromArray($details['phone_numbers']) : null,
            array_key_exists('locale', $details) ? Locale::fromString($details['locale']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'merchant_customer_id' => ($this->merchantCustomerId() !== null)
                ? $this->merchantCustomerId()->toString() : null,
            'email_address' => ($this->emailAddress() !== null) ? $this->emailAddress()->toString() : null,
            'first_name' => ($this->firstName() !== null) ? $this->firstName()->toString() : null,
            'last_name' => ($this->lastName() !== null) ? $this->lastName()->toString() : null,
            'address_type' => ($this->addressType() !== null) ? $this->addressType()->toString() : null,
            'address' => ($this->address() !== null) ? $this->address()->toString() : null,
            'postal_code' => ($this->postalCode() !== null) ? $this->postalCode()->toString() : null,
            'housenumber' => ($this->housenumber() !== null) ? $this->housenumber()->toString() : null,
            'country' => ($this->country() !== null) ? $this->country()->toString() : null,
            'phone_numbers' => ($this->phoneNumbers() !== null) ? $this->phoneNumbers()->toArray() : [],
            'locale' => ($this->locale() !== null) ? $this->locale()->toString() : null
        ];
    }

    /**
     * @return MerchantCustomerId|null
     */
    public function merchantCustomerId()
    {
        return $this->merchantCustomerId;
    }

    /**
     * @return EmailAddress|null
     */
    public function emailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * @return FirstName|null
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * @return LastName|null
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * @return AddressType|null
     */
    public function addressType()
    {
        return $this->addressType;
    }

    /**
     * @return Address|null
     */
    public function address()
    {
        return $this->address;
    }

    /**
     * @return PostalCode|null
     */
    public function postalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return Housenumber|null
     */
    public function housenumber()
    {
        return $this->housenumber;
    }

    /**
     * @return Country|null
     */
    public function country()
    {
        return $this->country;
    }

    /**
     * @return PhoneNumbers|null
     */
    public function phoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @return Locale|null
     */
    public function locale()
    {
        return $this->locale;
    }

    /**
     * @param MerchantCustomerId $merchantCustomerId
     * @param EmailAddress $emailAddress
     * @param FirstName $firstName
     * @param LastName $lastName
     * @param AddressType $addressType
     * @param Address $address
     * @param PostalCode $postalCode
     * @param Housenumber $housenumber
     * @param Country $country
     * @param PhoneNumbers $phoneNumbers
     * @param Locale $locale
     */
    private function __construct(
        MerchantCustomerId $merchantCustomerId = null,
        EmailAddress $emailAddress = null,
        FirstName $firstName = null,
        LastName $lastName = null,
        AddressType $addressType = null,
        Address $address = null,
        PostalCode $postalCode = null,
        Housenumber $housenumber = null,
        Country $country = null,
        PhoneNumbers $phoneNumbers = null,
        Locale $locale = null
    )
    {
        $this->merchantCustomerId = $merchantCustomerId;
        $this->emailAddress = $emailAddress;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->addressType = $addressType;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->housenumber = $housenumber;
        $this->country = $country;
        $this->phoneNumbers = $phoneNumbers;
        $this->locale = $locale;
    }
}
