<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Iban;
use GingerPayments\Payment\SwiftBic;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCity;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\Status;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\TransactionId;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCountry;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerAddress;

class IdealPaymentMethodDetails implements PaymentMethodDetails
{
    /**
     * @var SwiftBic
     */
    private $issuerId;

    /**
     * @var Status|null
     */
    private $status;

    /**
     * @var TransactionId|null
     */
    private $transactionId;

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
     * @var Iban|null
     */
    private $consumerIban;

    /**
     * @var SwiftBic|null
     */
    private $consumerBic;

    /**
     * @param array $details
     * @return IdealPaymentMethodDetails
     */
    public static function fromArray(array $details)
    {
        Guard::keyExists($details, 'issuer_id');

        return new static(
            SwiftBic::fromString($details['issuer_id']),
            array_key_exists('status', $details)
                ? Status::fromString($details['status']) : null,
            array_key_exists('transaction_id', $details)
                ? TransactionId::fromString($details['transaction_id']) : null,
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
                ? SwiftBic::fromString($details['consumer_bic']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'issuer_id' => $this->issuerId()->toString(),
            'transaction_id' => ($this->transactionId() !== null) ? $this->transactionId()->toString() : null,
            'status' => ($this->status() !== null) ? $this->status()->toString() : null,
            'consumer_name' => ($this->consumerName() !== null) ? $this->consumerName()->toString() : null,
            'consumer_address' => ($this->consumerAddress() !== null) ? $this->consumerAddress()->toString() : null,
            'consumer_city' => ($this->consumerCity() !== null) ? $this->consumerCity()->toString() : null,
            'consumer_country' => ($this->consumerCountry() !== null) ? $this->consumerCountry()->toString() : null,
            'consumer_iban' => ($this->consumerIban() !== null) ? $this->consumerIban()->toString() : null,
            'consumer_bic' => ($this->consumerBic() !== null) ? $this->consumerBic()->toString() : null
        ];
    }

    /**
     * @return SwiftBic
     */
    public function issuerId()
    {
        return $this->issuerId;
    }

    /**
     * @return Status|null
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return TransactionId|null
     */
    public function transactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return ConsumerName|null
     */
    public function consumerName()
    {
        return $this->consumerName;
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
     * @return Iban|null
     */
    public function consumerIban()
    {
        return $this->consumerIban;
    }

    /**
     * @return SwiftBic|null
     */
    public function consumerBic()
    {
        return $this->consumerBic;
    }

    /**
     * @param SwiftBic $issuerId
     * @param Status $status
     * @param TransactionId $transactionId
     * @param ConsumerName $consumerName
     * @param ConsumerAddress $consumerAddress
     * @param ConsumerCity $consumerCity
     * @param ConsumerCountry $consumerCountry
     * @param Iban $consumerIban
     * @param SwiftBic $consumerBic
     */
    private function __construct(
        SwiftBic $issuerId,
        Status $status = null,
        TransactionId $transactionId = null,
        ConsumerName $consumerName = null,
        ConsumerAddress $consumerAddress = null,
        ConsumerCity $consumerCity = null,
        ConsumerCountry $consumerCountry = null,
        Iban $consumerIban = null,
        SwiftBic $consumerBic = null
    ) {
        $this->issuerId = $issuerId;
        $this->status = $status;
        $this->transactionId = $transactionId;
        $this->consumerName = $consumerName;
        $this->consumerAddress = $consumerAddress;
        $this->consumerCity = $consumerCity;
        $this->consumerCountry = $consumerCountry;
        $this->consumerIban = $consumerIban;
        $this->consumerBic = $consumerBic;
    }
}
