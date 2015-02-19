<?php

namespace GingerPayments\Payment\Order;

use Assert\Assertion as Guard;

final class OrderStatus
{
    /**
     * Possible order statuses
     */
    const BRAND_NEW = 'new';
    const PROCESSING = 'processing';
    const ERROR = 'error';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const EXPIRED = 'expired';
    const SEE_TRANSACTIONS = 'see-transactions';

    /**
     * @var array
     */
    private static $possibleStatuses = array(
        self::BRAND_NEW,
        self::PROCESSING,
        self::ERROR,
        self::COMPLETED,
        self::CANCELLED,
        self::EXPIRED,
        self::SEE_TRANSACTIONS
    );

    /**
     * @var string
     */
    private $status;

    /**
     * Factory method. Returns a new instance from a string.
     *
     * @param string $status
     * @return OrderStatus
     */
    public static function fromString($status)
    {
        return new static((string) $status);
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->status === self::BRAND_NEW;
    }

    /**
     * @return bool
     */
    public function isProcessing()
    {
        return $this->status === self::PROCESSING;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->status === self::ERROR;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === self::COMPLETED;
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === self::CANCELLED;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->status === self::EXPIRED;
    }

    /**
     * @return bool
     */
    public function isSeeTransactions()
    {
        return $this->status === self::SEE_TRANSACTIONS;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * @param string $status
     */
    private function __construct($status)
    {
        Guard::choice(
            $status,
            static::$possibleStatuses,
            'Provided status must be one of ' . implode(', ', self::$possibleStatuses)
        );

        $this->status = $status;
    }
}
