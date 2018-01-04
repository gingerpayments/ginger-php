<?php

namespace GingerPayments\Payment\Order\Transaction;

use GingerPayments\Payment\Common\ChoiceBasedValueObject;

final class Status
{
    use ChoiceBasedValueObject;

    /**
     * Possible transaction statuses
     */
    const BRAND_NEW = 'new';
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const ERROR = 'error';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';
    const EXPIRED = 'expired';
    const ACCEPTED = 'accepted';
    const CAPTURED = 'captured';
    const DECLINED = 'declined';

    /**
     * @return array
     */
    public function possibleValues()
    {
        return [
            self::BRAND_NEW,
            self::PENDING,
            self::PROCESSING,
            self::ERROR,
            self::COMPLETED,
            self::CANCELLED,
            self::EXPIRED,
            self::ACCEPTED,
            self::CAPTURED,
            self::DECLINED
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
    public function isPending()
    {
        return $this->value === self::PENDING;
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
    public function isAccepted()
    {
        return $this->value === self::ACCEPTED;
    }

    /**
     * @return bool
     */
    public function isCaptured()
    {
        return $this->value === self::CAPTURED;
    }

    /**
     * @return bool
     */
    public function isDeclined()
    {
        return $this->value === self::DECLINED;
    }
}
