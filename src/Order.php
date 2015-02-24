<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;
use GingerPayments\Payment\Order\Amount;
use GingerPayments\Payment\Order\Description;
use GingerPayments\Payment\Order\MerchantOrderId;
use GingerPayments\Payment\Order\Status;
use GingerPayments\Payment\Order\Transaction;
use GingerPayments\Payment\Order\Transaction\PaymentMethod;
use GingerPayments\Payment\Order\Transactions;
use Rhumsaa\Uuid\Uuid;

final class Order
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
     * @var MerchantOrderId|null
     */
    private $merchantOrderId;

    /**
     * @var Uuid|null
     */
    private $projectId;

    /**
     * @var Status|null
     */
    private $status;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @var Amount
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
     * @var Url|null
     */
    private $returnUrl;

    /**
     * @var Transactions
     */
    private $transactions;

    /**
     * Create a new Order with the iDEAL payment method.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param string $issuerId The SWIFT/BIC code of the iDEAL issuer.
     * @param string $description A description of the order.
     * @param string $merchantOrderId A merchant-defined order identifier.
     * @param string $returnUrl The return URL.
     * @param string $expirationPeriod The expiration period as an ISO 8601 duration
     * @return Order
     */
    public static function createWithIdeal(
        $amount,
        $currency,
        $issuerId,
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::IDEAL,
            ['issuer_id' => $issuerId],
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod
        );
    }

    /**
     * Create a new Order with the credit card payment method.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param string $description A description of the order.
     * @param string $merchantOrderId A merchant-defined order identifier.
     * @param string $returnUrl The return URL.
     * @param string $expirationPeriod The expiration period as an ISO 8601 duration
     * @return Order
     */
    public static function createWithCreditCard(
        $amount,
        $currency,
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::CREDIT_CARD,
            [],
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod
        );
    }

    /**
     * Create a new Order.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param string $paymentMethod The payment method to use.
     * @param array $paymentMethodDetails An array of extra payment method details.
     * @param string $description A description of the order.
     * @param string $merchantOrderId A merchant-defined order identifier.
     * @param string $returnUrl The return URL.
     * @param string $expirationPeriod The expiration period as an ISO 8601 duration
     * @return Order
     */
    public static function create(
        $amount,
        $currency,
        $paymentMethod,
        array $paymentMethodDetails = array(),
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null
    ) {
        return new static(
            Transactions::fromArray(
                array(
                    array(
                        'payment_method' => $paymentMethod,
                        'payment_method_details' => $paymentMethodDetails
                    )
                )
            ),
            Amount::fromInteger($amount),
            Currency::fromString($currency),
            ($description !== null) ? Description::fromString($description) : null,
            ($merchantOrderId !== null) ? MerchantOrderId::fromString($merchantOrderId) : null,
            ($returnUrl !== null) ? Url::fromString($returnUrl) : null,
            ($expirationPeriod !== null) ? new \DateInterval($expirationPeriod) : null
        );
    }

    /**
     * @param array $order
     * @return Transaction
     */
    public static function fromArray(array $order)
    {
        Guard::keyExists($order, 'transactions');
        Guard::keyExists($order, 'amount');
        Guard::keyExists($order, 'currency');

        return new static(
            Transactions::fromArray($order['transactions']),
            Amount::fromInteger($order['amount']),
            Currency::fromString($order['currency']),
            array_key_exists('description', $order) ? Description::fromString($order['description']) : null,
            array_key_exists('merchant_order_id', $order)
                ? MerchantOrderId::fromString($order['merchant_order_id'])
                : null,
            array_key_exists('return_url', $order) ? Url::fromString($order['return_url']) : null,
            array_key_exists('expiration_period', $order) ? new \DateInterval($order['expiration_period']) : null,
            array_key_exists('id', $order) ? Uuid::fromString($order['id']) : null,
            array_key_exists('project_id', $order) ? Uuid::fromString($order['project_id']) : null,
            array_key_exists('created', $order) ? new \DateTimeImmutable($order['created']) : null,
            array_key_exists('modified', $order) ? new \DateTimeImmutable($order['modified']) : null,
            array_key_exists('completed', $order) ? new \DateTimeImmutable($order['completed']) : null,
            array_key_exists('status', $order) ? Status::fromString($order['status']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array(
            'currency' => $this->currency()->toString(),
            'amount' => $this->amount()->toInteger(),
            'transactions' => $this->transactions()->toArray(),
            'id' => ($this->id() !== null) ? $this->id()->toString() : null,
            'project_id' => ($this->projectId() !== null) ? $this->projectId()->toString() : null,
            'created' => ($this->created() !== null) ? $this->created()->format('c') : null,
            'modified' => ($this->modified() !== null) ? $this->modified()->format('c') : null,
            'completed' => ($this->completed() !== null) ? $this->completed()->format('c') : null,
            'expiration_period' => ($this->expirationPeriod() !== null)
                ? $this->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
                : null,
            'merchant_order_id' => ($this->merchantOrderId() !== null)
                ? $this->merchantOrderId()->toString()
                : null,
            'status' => ($this->status() !== null) ? $this->status()->toString() : null,
            'description' => ($this->description() !== null) ? $this->description()->toString() : null,
            'return_url' => ($this->returnUrl() !== null) ? $this->returnUrl()->toString() : null,
        );
    }

    /**
     * @return Uuid|null
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
     * @return Uuid|null
     */
    public function projectId()
    {
        return $this->projectId;
    }

    /**
     * @return MerchantOrderId|null
     */
    public function merchantOrderId()
    {
        return $this->merchantOrderId;
    }

    /**
     * @return Status|null
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return Currency
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * @return Amount
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
     * @return Url|null
     */
    public function returnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @return Transactions
     */
    public function transactions()
    {
        return $this->transactions;
    }

    /**
     * @param Transactions $transactions
     * @param Amount $amount
     * @param Currency $currency
     * @param Description $description
     * @param MerchantOrderId $merchantOrderId
     * @param Url $returnUrl
     * @param \DateInterval $expirationPeriod
     * @param Uuid $id
     * @param Uuid $projectId
     * @param \DateTimeImmutable $created
     * @param \DateTimeImmutable $modified
     * @param \DateTimeImmutable $completed
     * @param Status $status
     */
    private function __construct(
        Transactions $transactions,
        Amount $amount,
        Currency $currency,
        Description $description = null,
        MerchantOrderId $merchantOrderId = null,
        Url $returnUrl = null,
        \DateInterval $expirationPeriod = null,
        Uuid $id = null,
        Uuid $projectId = null,
        \DateTimeImmutable $created = null,
        \DateTimeImmutable $modified = null,
        \DateTimeImmutable $completed = null,
        Status $status = null
    ) {
        $this->transactions = $transactions;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->merchantOrderId = $merchantOrderId;
        $this->returnUrl = $returnUrl;
        $this->expirationPeriod = $expirationPeriod;
        $this->id = $id;
        $this->projectId = $projectId;
        $this->created = $created;
        $this->modified = $modified;
        $this->completed = $completed;
        $this->status = $status;
    }
}
