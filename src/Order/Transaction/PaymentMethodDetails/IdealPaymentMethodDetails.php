<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Iban;
use GingerPayments\Payment\SwiftBic;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerCity;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\ConsumerName;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\Status;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\IdealPaymentMethodDetails\TransactionId;

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
     * @var ConsumerCity|null
     */
    private $consumerCity;

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
            array_key_exists('status', $details) ? Status::fromString($details['status']) : null,
            array_key_exists('transaction_id', $details) ? TransactionId::fromString($details['transaction_id']) : null,
            array_key_exists('consumer_name', $details) ? ConsumerName::fromString($details['consumer_name']) : null,
            array_key_exists('consumer_city', $details) ? ConsumerCity::fromString($details['consumer_city']) : null,
            array_key_exists('consumer_iban', $details) ? Iban::fromString($details['consumer_iban']) : null,
            array_key_exists('consumer_bic', $details) ? SwiftBic::fromString($details['consumer_bic']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'issuer_id' => $this->issuerId()->toString(),
            'transaction_id' => ($this->transactionId() !== null) ? $this->transactionId()->toString() : null,
            'consumer_name' => ($this->consumerName() !== null) ? $this->consumerName()->toString() : null,
            'consumer_city' => ($this->consumerCity() !== null) ? $this->consumerCity()->toString() : null,
            'consumer_iban' => ($this->consumerIban() !== null) ? $this->consumerIban()->toString() : null,
            'consumer_bic' => ($this->consumerBic() !== null) ? $this->consumerBic()->toString() : null
        );
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
     * @return ConsumerCity|null
     */
    public function consumerCity()
    {
        return $this->consumerCity;
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
     * @param ConsumerCity $consumerCity
     * @param Iban $consumerIban
     * @param SwiftBic $consumerBic
     */
    private function __construct(
        SwiftBic $issuerId,
        Status $status = null,
        TransactionId $transactionId = null,
        ConsumerName $consumerName = null,
        ConsumerCity $consumerCity = null,
        Iban $consumerIban = null,
        SwiftBic $consumerBic = null
    ) {
        $this->issuerId = $issuerId;
        $this->status = $status;
        $this->transactionId = $transactionId;
        $this->consumerName = $consumerName;
        $this->consumerCity = $consumerCity;
        $this->consumerIban = $consumerIban;
        $this->consumerBic = $consumerBic;
    }
}
