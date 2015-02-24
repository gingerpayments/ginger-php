<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Currency;
use GingerPayments\Payment\Order\Transaction\Balance;
use GingerPayments\Payment\Order\Transaction\PaymentMethod;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;
use GingerPayments\Payment\Order\Transaction\Reason;
use GingerPayments\Payment\Order\Transaction\Status as TransactionStatus;
use GingerPayments\Payment\Url;
use Rhumsaa\Uuid\Uuid;

final class Transaction
{
    /**
     * @var Uuid|null
     */
    private $id;

    /**
     * @var \DateTimeImmutable|null
     */
    private $created;

    /**
     * @var \DateTimeImmutable|null
     */
    private $modified;

    /**
     * @var \DateTimeImmutable|null
     */
    private $completed;

    /**
     * @var TransactionStatus|null
     */
    private $status;

    /**
     * @var Reason|null
     */
    private $reason;

    /**
     * @var Currency|null
     */
    private $currency;

    /**
     * @var Amount|null
     */
    private $amount;

    /**
     * @var \DateInterval|null
     */
    private $expirationPeriod;

    /**
     * @var Description|null
     */
    private $description;

    /**
     * @var Balance|null
     */
    private $balance;

    /**
     * @var PaymentMethod
     */
    private $paymentMethod;

    /**
     * @var PaymentMethodDetails
     */
    private $paymentMethodDetails;

    /**
     * @var Url|null
     */
    private $paymentUrl;

    /**
     * @param array $transaction
     * @return Transaction
     */
    public static function fromArray(array $transaction)
    {
        Guard::keyExists($transaction, 'payment_method');

        return new static(
            PaymentMethod::fromString($transaction['payment_method']),
            PaymentMethodDetails\PaymentMethodDetailsFactory::createFromArray(
                PaymentMethod::fromString($transaction['payment_method']),
                array_key_exists('payment_method_details', $transaction) ? $transaction['payment_method_details'] : array()
            ),
            array_key_exists('id', $transaction) ? Uuid::fromString($transaction['id']) : null,
            array_key_exists('created', $transaction) ? new \DateTimeImmutable($transaction['created']) : null,
            array_key_exists('modified', $transaction) ? new \DateTimeImmutable($transaction['modified']) : null,
            array_key_exists('completed', $transaction) ? new \DateTimeImmutable($transaction['completed']) : null,
            array_key_exists('status', $transaction) ? TransactionStatus::fromString($transaction['status']) : null,
            array_key_exists('reason', $transaction) ? Reason::fromString($transaction['reason']) : null,
            array_key_exists('currency', $transaction) ? Currency::fromString($transaction['currency']) : null,
            array_key_exists('amount', $transaction) ? Amount::fromInteger($transaction['amount']) : null,
            array_key_exists('expiration_period', $transaction) ? new \DateInterval($transaction['expiration_period']) : null,
            array_key_exists('description', $transaction) ? Description::fromString($transaction['description']) : null,
            array_key_exists('balance', $transaction) ? Balance::fromString($transaction['balance']) : null,
            array_key_exists('payment_url', $transaction) ? Url::fromString($transaction['payment_url']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'payment_method' => $this->paymentMethod()->toString(),
            'payment_method_details' => $this->paymentMethodDetails()->toArray(),
            'id' => ($this->id() !== null) ? $this->id()->toString() : null,
            'created' => ($this->created() !== null) ? $this->created()->format('c') : null,
            'modified' => ($this->modified() !== null) ? $this->modified()->format('c') : null,
            'completed' => ($this->completed() !== null) ? $this->completed()->format('c') : null,
            'status' => ($this->status() !== null) ? $this->status()->toString() : null,
            'reason' => ($this->reason() !== null) ? $this->reason()->toString() : null,
            'currency' => ($this->currency() !== null) ? $this->currency()->toString() : null,
            'amount' => ($this->amount() !== null) ? $this->amount()->toInteger() : null,
            'expiration_period' => ($this->expirationPeriod() !== null) ? $this->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS') : null,
            'description' => ($this->description() !== null) ? $this->description()->toString() : null,
            'balance' => ($this->balance() !== null) ? $this->balance()->toString() : null,
            'payment_url' => ($this->paymentUrl() !== null) ? $this->paymentUrl()->toString() : null
        );
    }

    /**
     * @return null|Uuid
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function created()
    {
        return $this->created;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function modified()
    {
        return $this->modified;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function completed()
    {
        return $this->completed;
    }

    /**
     * @return TransactionStatus|null
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return Reason|null
     */
    public function reason()
    {
        return $this->reason;
    }

    /**
     * @return Currency|null
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * @return Amount|null
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return \DateInterval|null
     */
    public function expirationPeriod()
    {
        return $this->expirationPeriod;
    }

    /**
     * @return Description|null
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return Balance|null
     */
    public function balance()
    {
        return $this->balance;
    }

    /**
     * @return PaymentMethod
     */
    public function paymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return PaymentMethodDetails|null
     */
    public function paymentMethodDetails()
    {
        return $this->paymentMethodDetails;
    }

    /**
     * @return Url|null
     */
    public function paymentUrl()
    {
        return $this->paymentUrl;
    }

    /**
     * @param PaymentMethod $paymentMethod
     * @param PaymentMethodDetails $paymentMethodDetails
     * @param Uuid $id
     * @param \DateTimeImmutable $created
     * @param \DateTimeImmutable $modified
     * @param \DateTimeImmutable $completed
     * @param TransactionStatus $status
     * @param Reason $reason
     * @param Currency $currency
     * @param Amount $amount
     * @param \DateInterval $expirationPeriod
     * @param Description $description
     * @param Balance $balance
     * @param Url $paymentUrl
     */
    private function __construct(
        PaymentMethod $paymentMethod,
        PaymentMethodDetails $paymentMethodDetails,
        Uuid $id = null,
        \DateTimeImmutable $created = null,
        \DateTimeImmutable $modified = null,
        \DateTimeImmutable $completed = null,
        TransactionStatus $status = null,
        Reason $reason = null,
        Currency $currency = null,
        Amount $amount = null,
        \DateInterval $expirationPeriod = null,
        Description $description = null,
        Balance $balance = null,
        Url $paymentUrl = null
    ) {
        $this->paymentMethod = $paymentMethod;
        $this->paymentMethodDetails = $paymentMethodDetails;
        $this->id = $id;
        $this->created = $created;
        $this->modified = $modified;
        $this->completed = $completed;
        $this->status = $status;
        $this->reason = $reason;
        $this->currency = $currency;
        $this->amount = $amount;
        $this->expirationPeriod = $expirationPeriod;
        $this->description = $description;
        $this->balance = $balance;
        $this->paymentUrl = $paymentUrl;
    }
}
