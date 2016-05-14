<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;
use Carbon\Carbon;
use GingerPayments\Payment\Order\Amount;
use GingerPayments\Payment\Order\Description;
use GingerPayments\Payment\Order\MerchantOrderId;
use GingerPayments\Payment\Order\Status;
use GingerPayments\Payment\Order\Transaction;
use GingerPayments\Payment\Order\Transaction\PaymentMethod;
use GingerPayments\Payment\Order\Transactions;
use GingerPayments\Payment\Order\Customer;
use Rhumsaa\Uuid\Uuid;

final class Order
{
    /**
     * @var Uuid|null
     */
    private $id;

    /**
     * @var Carbon|null
     */
    private $created;

    /**
     * @var Carbon|null
     */
    private $modified;

    /**
     * @var Carbon|null
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
     * @var Customer|null
     */
    private $customer;

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
     * @param array $customer Customer information.
     *
     * @return Order
     */
    public static function createWithIdeal(
        $amount,
        $currency,
        $issuerId,
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::IDEAL,
            ['issuer_id' => $issuerId],
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod,
            $customer
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
     * @param array $customer Customer information.
     * @return Order
     */
    public static function createWithCreditCard(
        $amount,
        $currency,
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::CREDIT_CARD,
            [],
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod,
            $customer
        );
    }

    /**
     * Create a new Order with the SEPA payment method.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param array $paymentMethodDetails An array of extra payment method details.
     * @param string $description A description of the order.
     * @param string $merchantOrderId A merchant-defined order identifier.
     * @param string $returnUrl The return URL.
     * @param string $expirationPeriod The expiration period as an ISO 8601 duration.
     * @param array $customer Customer information
     * @return Order
     */
    public static function createWithSepa(
        $amount,
        $currency,
        array $paymentMethodDetails = [],
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::BANK_TRANSFER,
            $paymentMethodDetails,
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod,
            $customer
        );
    }
    /**
     * Create a new Order with the SOFORT payment method.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param array $paymentMethodDetails An array of extra payment method details.
     * @param string $description A description of the order.
     * @param string $merchantOrderId A merchant-defined order identifier.
     * @param string $returnUrl The return URL.
     * @param string $expirationPeriod The expiration period as an ISO 8601 duration.
     * @param array $customer Customer information.
     * @return Order
     */
    public static function createWithSofort(
        $amount,
        $currency,
        array $paymentMethodDetails = [],
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::SOFORT,
            $paymentMethodDetails,
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod,
            $customer
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
     * @param array $customer Customer information.
     * @return Order
     */
    public static function create(
        $amount,
        $currency,
        $paymentMethod,
        array $paymentMethodDetails = [],
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null
    ) {
        return new static(
            Transactions::fromArray(
                [
                    [
                        'payment_method' => $paymentMethod,
                        'payment_method_details' => $paymentMethodDetails
                    ]
                ]
            ),
            Amount::fromInteger($amount),
            Currency::fromString($currency),
            ($description !== null) ? Description::fromString($description) : null,
            ($merchantOrderId !== null) ? MerchantOrderId::fromString($merchantOrderId) : null,
            ($returnUrl !== null) ? Url::fromString($returnUrl) : null,
            ($expirationPeriod !== null) ? new \DateInterval($expirationPeriod) : null,
            null,
            null,
            null,
            null,
            null,
            null,
            ($customer !== null) ? Customer::fromArray($customer) : null
        );
    }

    /**
     * @param array $order
     * @return Order
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
            array_key_exists('created', $order) ? new Carbon($order['created']) : null,
            array_key_exists('modified', $order) ? new Carbon($order['modified']) : null,
            array_key_exists('completed', $order) ? new Carbon($order['completed']) : null,
            array_key_exists('status', $order) ? Status::fromString($order['status']) : null,
            array_key_exists('customer', $order) && $order['customer'] !== null ? Customer::fromArray($order['customer']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'currency' => $this->currency()->toString(),
            'amount' => $this->amount()->toInteger(),
            'transactions' => $this->transactions()->toArray(),
            'id' => ($this->id() !== null) ? $this->id()->toString() : null,
            'project_id' => ($this->projectId() !== null) ? $this->projectId()->toString() : null,
            'created' => ($this->created() !== null) ? $this->created()->toIso8601String() : null,
            'modified' => ($this->modified() !== null) ? $this->modified()->toIso8601String() : null,
            'completed' => ($this->completed() !== null) ? $this->completed()->toIso8601String() : null,
            'expiration_period' => ($this->expirationPeriod() !== null)
                ? $this->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
                : null,
            'merchant_order_id' => ($this->merchantOrderId() !== null)
                ? $this->merchantOrderId()->toString()
                : null,
            'status' => ($this->status() !== null) ? $this->status()->toString() : null,
            'description' => ($this->description() !== null) ? $this->description()->toString() : null,
            'return_url' => ($this->returnUrl() !== null) ? $this->returnUrl()->toString() : null,
            'customer' => ($this->customer() !== null) ? $this->customer()->toArray() : null
        ];
    }

    /**
     * @return Uuid|null
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return Carbon|null
     */
    public function created()
    {
        return $this->created;
    }

    /**
     * @return Carbon|null
     */
    public function modified()
    {
        return $this->modified;
    }

    /**
     * @return Carbon|null
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
     * @param string $merchantOrderId
     * @return MerchantOrderId|null
     */
    public function merchantOrderId($merchantOrderId = null)
    {
        if ($merchantOrderId) {
            $this->merchantOrderId = MerchantOrderId::fromString($merchantOrderId);
        }

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
     * @param string $currency
     * @return Currency
     */
    public function currency($currency = null)
    {
        if ($currency) {
            $this->currency = Currency::fromString($currency);
        }

        return $this->currency;
    }

    /**
     * @param int $amount
     * @return Amount
     */
    public function amount($amount = null)
    {
        if ($amount) {
            $this->amount = Amount::fromInteger($amount);
        }

        return $this->amount;
    }

    /**
     * Time interval (ISO 8601 / RFC 3339)
     * @param string $expirationPeriod
     * @return \DateInterval|null
     */
    public function expirationPeriod($expirationPeriod = null)
    {
        if ($expirationPeriod) {
            $this->expirationPeriod =  new \DateInterval($expirationPeriod);
        }

        return $this->expirationPeriod;
    }

    /**
     * @param string $description
     * @return Description|null
     */
    public function description($description = null)
    {
        if ($description) {
            $this->description = Description::fromString($description);
        }

        return $this->description;
    }

    /**
     * @param string $returnUrl
     * @return Url|null
     */
    public function returnUrl($returnUrl = null)
    {
        if ($returnUrl) {
            $this->returnUrl = Url::fromString($returnUrl);
        }

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
     * @return Url|null
     */
    public function firstTransactionPaymentUrl()
    {
        return $this->transactions()->firstPaymentUrl();
    }

    /**
     * @return Customer|null
     */
    public function customer()
    {
        return $this->customer;
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
     * @param Carbon $created
     * @param Carbon $modified
     * @param Carbon $completed
     * @param Status $status
     * @param Customer $customer
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
        Carbon $created = null,
        Carbon $modified = null,
        Carbon $completed = null,
        Status $status = null,
        Customer $customer = null
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
        $this->customer = $customer;
    }
}
