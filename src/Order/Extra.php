<?php

namespace GingerPayments\Payment\Order;

final class Extra
{
    /**
     * @var array|null
     */
    private $extra;

    /**
     * @param array $details
     * @return Extra
     */
    public static function fromArray(array $details)
    {
        return new static($details);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->extra();
    }

    /**
     * @return array|null
     */
    public function extra()
    {
        return $this->extra;
    }

    /**
     * @param array $extra
     */
    private function __construct(array $extra = null)
    {
        $this->extra = $extra;
    }
}
