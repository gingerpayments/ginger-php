<?php

namespace GingerPayments\Payment;

final class Order
{
    /**
     * @var OrderIdentifier|null
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
     * @var OrderMerchantIdentifier|null
     */
    private $merchantOrderId;

    /**
     * @var OrderStatus|null
     */
    private $status;

    /**
     * @var OrderCurrency
     */
    private $currency;

    /**
     * @var OrderAmount
     */
    private $amount;

    /**
     * @var OrderDescription|null
     */
    private $description;

    /**
     * @var OrderReturnUrl|null
     */
    private $returnUrl;

    /**
     * Create a new Order.
     *
     * @param integer $amount Amount in cents.
     * @param string $currency A valid currency code.
     * @param string|null $merchantOrderId A merchant-defined order identifier.
     * @param string|null $description A description of the order.
     * @param string|null $returnUrl The return URL.
     * @return Order
     */
    public static function create(
        $amount,
        $currency,
        $merchantOrderId = null,
        $description = null,
        $returnUrl = null
    ) {
        return new static(
            OrderAmount::fromInteger($amount),
            OrderCurrency::fromString($currency),
            ($merchantOrderId !== null) ? OrderMerchantIdentifier::fromString($merchantOrderId) : null,
            ($description !== null) ? OrderDescription::fromString($description) : null,
            ($returnUrl !== null) ? OrderReturnUrl::fromString($returnUrl) : null
        );
    }

    /**
     * @return OrderIdentifier|null
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
     * @return OrderMerchantIdentifier|null
     */
    public function merchantOrderId()
    {
        return $this->merchantOrderId;
    }

    /**
     * @return OrderStatus|null
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return OrderCurrency
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * @return OrderAmount
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return OrderDescription|null
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return OrderReturnUrl|null
     */
    public function returnUrl()
    {
        return $this->returnUrl;
    }

    /**
     * @return string
     * @todo Move to dedicated serializer
     */
    public function toJson()
    {
        return json_encode($this->toScalarArray());
    }

    /**
     * @return array
     */
    public function toScalarArray()
    {
        $array = array(
            'currency' => $this->currency()->toString(),
            'amount' => $this->amount()->toInteger()
        );

        if ($this->id() !== null) {
            $array['id'] = $this->id()->toString();
        }

        if ($this->created() !== null) {
            $array['created'] = $this->created()->format('c');
        }

        if ($this->modified() !== null) {
            $array['modified'] = $this->modified()->format('c');
        }

        if ($this->completed() !== null) {
            $array['completed'] = $this->completed()->format('c');
        }

        if ($this->merchantOrderId() !== null) {
            $array['merchantOrderId'] = $this->merchantOrderId()->toString();
        }

        if ($this->status() !== null) {
            $array['status'] = $this->status()->toString();
        }

        if ($this->description() !== null) {
            $array['description'] = $this->description()->toString();
        }

        if ($this->returnUrl() !== null) {
            $array['returnUrl'] = $this->returnUrl()->toString();
        }

        return $array;
    }

    /**
     * @param OrderAmount $amount
     * @param OrderCurrency $currency
     * @param OrderMerchantIdentifier $merchantOrderId
     * @param OrderDescription $description
     * @param OrderReturnUrl $returnUrl
     */
    private function __construct(
        OrderAmount $amount,
        OrderCurrency $currency,
        OrderMerchantIdentifier $merchantOrderId = null,
        OrderDescription $description = null,
        OrderReturnUrl $returnUrl = null
    ) {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->merchantOrderId = $merchantOrderId;
        $this->description = $description;
        $this->returnUrl = $returnUrl;
    }
}
