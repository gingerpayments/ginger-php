<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Iban;
use GingerPayments\Payment\Order\Transaction\Reference;
use GingerPayments\Payment\SwiftBic;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\ConsumerName;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerAddress;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCity;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCountry;

final class SepaPaymentMethodDetails implements PaymentMethodDetails
{
    /**
     * @var Reference
     */
    private $reference;

    /**
     * @var Iban|null
     */
    private $consumerIban;
    
    /**
     * @var SwiftBic|null
     */
    private $consumerBic;

    /**
     * @var ConsumerName|null
     */
    private $consumerName;

    /**
     * @var ConsumerAddress|null
     */
    private $consumerAddress;

    /**
     * @var ConsumerCity|null
     */
    private $consumerCity;

    /**
     * @var ConsumerCountry|null
     */
    private $consumerCountry;

    /**
     * @param array $details
     * @return SepaPaymentMethodDetails
     */
    public static function fromArray(array $details)
    {
        return new static(
            array_key_exists('consumer_name', $details)
                ? ConsumerName::fromString($details['consumer_name']) : null,
            array_key_exists('consumer_address', $details)
                ? ConsumerAddress::fromString($details['consumer_address']) : null,
            array_key_exists('consumer_city', $details)
                ? ConsumerCity::fromString($details['consumer_city']) : null,
            array_key_exists('consumer_country', $details)
                ? ConsumerCountry::fromString($details['consumer_country']) : null,
            array_key_exists('consumer_iban', $details)
                ? Iban::fromString($details['consumer_iban']) : null,
            array_key_exists('consumer_bic', $details)
                ? SwiftBic::fromString($details['consumer_bic']) : null,
            array_key_exists('reference', $details)
                ? Reference::fromString($details['reference']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'consumer_name' => ($this->consumerName() !== null) ? $this->consumerName()->toString() : null,
            'consumer_address' => ($this->consumerAddress() !== null) ? $this->consumerAddress()->toString() : null,
            'consumer_city' => ($this->consumerCity() !== null) ? $this->consumerCity()->toString() : null,
            'consumer_country' => ($this->consumerCountry() !== null) ? $this->consumerCountry()->toString() : null,
            'consumer_iban' => ($this->consumerIban() !== null) ? $this->consumerIban()->toString() : null,
            'consumer_bic' => ($this->consumerBic() !== null) ? $this->consumerBic()->toString() : null,
            'reference' => ($this->reference() !== null) ? $this->reference()->toString() : null
        ];
    }

    /**
     * @return SwiftBic|null
     */
    public function consumerBic()
    {
        return $this->consumerBic;
    }

    /**
     * @return Iban|null
     */
    public function consumerIban()
    {
        return $this->consumerIban;
    }

    /**
     * @return consumerName|null
     */
    public function consumerName()
    {
        return $this->consumerName;
    }

    /**
     * @return Reference
     */
    public function reference()
    {
        return $this->reference;
    }

    /**
     * @return ConsumerAddress|null
     */
    public function consumerAddress()
    {
        return $this->consumerAddress;
    }

    /**
     * @return ConsumerCity|null
     */
    public function consumerCity()
    {
        return $this->consumerCity;
    }

    /**
     * @return ConsumerCountry|null
     */
    public function consumerCountry()
    {
        return $this->consumerCountry;
    }

    /**
     * @param ConsumerName $consumerName
     * @param ConsumerAddress $consumerAddress
     * @param ConsumerCity $consumerCity
     * @param ConsumerCountry $consumerCountry
     * @param Iban $consumerIban
     * @param SwiftBic $consumerBic
     * @param Reference $reference
     */
    private function __construct(
        ConsumerName $consumerName = null,
        ConsumerAddress $consumerAddress = null,
        ConsumerCity $consumerCity = null,
        ConsumerCountry $consumerCountry = null,
        Iban $consumerIban = null,
        SwiftBic $consumerBic = null,
        Reference $reference = null
    ) {
        $this->consumerName = $consumerName;
        $this->consumerAddress = $consumerAddress;
        $this->consumerCity = $consumerCity;
        $this->consumerCountry = $consumerCountry;
        $this->consumerIban = $consumerIban;
        $this->consumerBic = $consumerBic;
        $this->reference = $reference;
    }
}
