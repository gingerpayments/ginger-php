<?php

namespace GingerPayments\Payment\Order;

use GingerPayments\Payment\Order\Extra\Plugin;

final class Extra
{
    /**
     * @var Plugin|null
     */
    private $plugin;

    /**
     * @param array $details
     * @return Extra
     */
    public static function fromArray(array $details)
    {
        return new static(
            array_key_exists('plugin', $details) ? Plugin::fromString($details['plugin']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'plugin' => ($this->plugin() !== null) ? $this->plugin()->toString() : null
        ];
    }

    /**
     * @return Plugin|null
     */
    public function plugin()
    {
        return $this->plugin;
    }

    /**
     * @param Plugin $plugin
     */
    private function __construct(Plugin $plugin = null)
    {
        $this->plugin = $plugin;
    }
}
