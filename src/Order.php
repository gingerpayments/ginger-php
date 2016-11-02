<?php

namespace GingerPayments\Payment;

use Assert\Assertion as Guard;
use Carbon\Carbon;
use GingerPayments\Payment\Order\Amount;
use GingerPayments\Payment\Order\Description;
use GingerPayments\Payment\Order\MerchantOrderId;
use GingerPayments\Payment\Order\Status;
use GingerPayments\Payment\Order\Transaction\PaymentMethod;
use GingerPayments\Payment\Order\Transactions;
use GingerPayments\Payment\Order\Customer;
use GingerPayments\Payment\Order\Extra;

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
     * Used for adding extra information to the order.
     *
     * @var Extra|null
     */
    private $extra;

    /**
     * Webhook URL is used for transaction information updates.
     *
     * @var Url|null
     */
    private $webhookUrl;

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
     * @param array $extra Extra information.
     * @param string $webhookUrl The webhook URL.
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
        $customer = null,
        $extra = null,
        $webhookUrl = null
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
            $customer,
            $extra,
            $webhookUrl
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
     * @param array $extra Extra information.
     * @param string $webhookUrl The webhook URL.
     *
     * @return Order
     */
    public static function createWithCreditCard(
        $amount,
        $currency,
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null,
        $extra = null,
        $webhookUrl = null
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
            $customer,
            $extra,
            $webhookUrl
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
     * @param array $extra Extra information.
     * @param string $webhookUrl The webhook URL.
     *
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
        $customer = null,
        $extra = null,
        $webhookUrl = null
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
            $customer,
            $extra,
            $webhookUrl
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
     * @param array $extra Extra information.
     * @param string $webhookUrl The webhook URL.
     *
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
        $customer = null,
        $extra = null,
        $webhookUrl = null
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
            $customer,
            $extra,
            $webhookUrl
        );
    }

    /**
     * Create a new Order with the Bancontact payment method.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param string $description A description of the order.
     * @param string $merchantOrderId A merchant-defined order identifier.
     * @param string $returnUrl The return URL.
     * @param string $expirationPeriod The expiration period as an ISO 8601 duration.
     * @param array $customer Customer information.
     * @param array $extra Extra information.
     * @param string $webhookUrl The webhook URL.
     *
     * @return Order
     */
    public static function createWithBancontact(
        $amount,
        $currency,
        $description = null,
        $merchantOrderId = null,
        $returnUrl = null,
        $expirationPeriod = null,
        $customer = null,
        $extra = null,
        $webhookUrl = null
    ) {
        return static::create(
            $amount,
            $currency,
            PaymentMethod::BANCONTACT,
            [],
            $description,
            $merchantOrderId,
            $returnUrl,
            $expirationPeriod,
            $customer,
            $extra,
            $webhookUrl
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
     * @param array $extra Extra information.
     * @param string $webhookUrl The webhook URL.
     *
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
        $customer = null,
        $extra = null,
        $webhookUrl = null
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
            ($customer !== null) ? Customer::fromArray($customer) : null,
            ($extra !== null) ? Extra::fromArray($extra) : null,
            ($webhookUrl !== null) ? Url::fromString($webhookUrl) : null
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
            array_key_exists('customer', $order) && $order['customer'] !== null
                ? Customer::fromArray($order['customer']) : null,
            array_key_exists('extra', $order) && $order['extra'] !== null
                ? Extra::fromArray($order['extra']) : null,
            array_key_exists('webhook_url', $order) ? Url::fromString($order['webhook_url']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'currency' => $this->getCurrency(),
            'amount' => $this->getAmount(),
            'transactions' => $this->getTransactions(),
            'id' => $this->getId(),
            'project_id' => $this->getProjectId(),
            'created' => $this->getCreated(),
            'modified' => $this->getModified(),
            'completed' => $this->getCompleted(),
            'expiration_period' => $this->getExpirationPeriod(),
            'merchant_order_id' => $this->getMerchantOrderId(),
            'status' => $this->getStatus(),
            'description' => $this->getDescription(),
            'return_url' => $this->getReturnUrl(),
            'customer' => $this->getCustomer(),
            'extra' => $this->getExtra(),
            'webhook_url' => $this->getWebhookUrl()
        ];
    }

    /**
     * @return string|null
     */
    public function getWebhookUrl()
    {
        return ($this->webhookUrl() !== null) ? $this->webhookUrl()->toString() : null;
    }

    /**
     * @return array
     */
    public function getTransactions()
    {
        return $this->transactions()->toArray();
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency()->toString();
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount()->toInteger();
    }

    /**
     * @return null|string
     */
    public function getId()
    {
        return ($this->id() !== null) ? $this->id()->toString() : null;
    }

    /**
     * @return null|string
     */
    public function getProjectId()
    {
        return ($this->projectId() !== null) ? $this->projectId()->toString() : null;
    }

    /**
     * @return null|string
     */
    public function getCreated()
    {
        return ($this->created() !== null) ? $this->created()->toIso8601String() : null;
    }

    /**
     * @return null|string
     */
    public function getModified()
    {
        return ($this->modified() !== null) ? $this->modified()->toIso8601String() : null;
    }

    /**
     * @return null|string
     */
    public function getCompleted()
    {
        return ($this->completed() !== null) ? $this->completed()->toIso8601String() : null;
    }

    /**
     * @return null|string
     */
    public function getExpirationPeriod()
    {
        return ($this->expirationPeriod() !== null)
            ? $this->expirationPeriod()->format('P%yY%mM%dDT%hH%iM%sS')
            : null;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return ($this->description() !== null) ? $this->description()->toString() : null;
    }

    /**
     * @return string|null
     */
    public function getStatus()
    {
        return ($this->status() !== null) ? $this->status()->toString() : null;
    }

    /**
     * @return string|null
     */
    public function getMerchantOrderId()
    {
        return ($this->merchantOrderId() !== null)
            ? $this->merchantOrderId()->toString()
            : null;
    }

    /**
     * @return string|null
     */
    public function getReturnUrl()
    {
        return ($this->returnUrl() !== null) ? $this->returnUrl()->toString() : null;
    }

    /**
     * @return array|null
     */
    public function getCustomer()
    {
        return ($this->customer() !== null) ? $this->customer()->toArray() : null;
    }

    /**
     * @return array|null
     */
    public function getExtra()
    {
        return ($this->extra() !== null) ? $this->extra()->toArray() : null;
    }

    /**
     * @return Extra|null
     */
    public function extra()
    {
        return $this->extra;
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
        if ($merchantOrderId !== null) {
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
        if ($currency !== null) {
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
        if ($amount !== null) {
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
        if ($expirationPeriod !== null) {
            $this->expirationPeriod = new \DateInterval($expirationPeriod);
        }

        return $this->expirationPeriod;
    }

    /**
     * @param string $description
     * @return Description|null
     */
    public function description($description = null)
    {
        if ($description !== null) {
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
        if ($returnUrl !== null) {
            $this->returnUrl = Url::fromString($returnUrl);
        }

        return $this->returnUrl;
    }

    /**
     * @param string $webhookUrl
     * @return Url|null
     */
    public function webhookUrl($webhookUrl = null)
    {
        if ($webhookUrl !== null) {
            $this->webhookUrl = Url::fromString($webhookUrl);
        }

        return $this->webhookUrl;
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
     * @param Extra $extra
     * @param Url $webhookUrl
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
        Customer $customer = null,
        Extra $extra = null,
        Url $webhookUrl = null
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
        $this->extra = $extra;
        $this->webhookUrl = $webhookUrl;
    }
}
