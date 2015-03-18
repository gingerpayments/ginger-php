<?php

namespace GingerPayments\Payment\Order;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class Status
{
    use ChoiceBasedValueObject;

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
     * @return array
     */
    public function possibleValues()
    {
        return [
            self::BRAND_NEW,
            self::PROCESSING,
            self::ERROR,
            self::COMPLETED,
            self::CANCELLED,
            self::EXPIRED,
            self::SEE_TRANSACTIONS
        ];
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return $this->value === self::BRAND_NEW;
    }

    /**
     * @return bool
     */
    public function isProcessing()
    {
        return $this->value === self::PROCESSING;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->value === self::ERROR;
    }

    /**
     * @return bool
     */
    public function isCompleted()
    {
        return $this->value === self::COMPLETED;
    }

    /**
     * @return bool
     */
    public function isCancelled()
    {
        return $this->value === self::CANCELLED;
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return $this->value === self::EXPIRED;
    }

    /**
     * @return bool
     */
    public function isSeeTransactions()
    {
        return $this->value === self::SEE_TRANSACTIONS;
    }
}
