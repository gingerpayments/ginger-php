<?php

namespace GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails\SetupToken;
use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\BancontactPaymentMethodDetails\VaultToken;
use Carbon\Carbon;

final class BancontactPaymentMethodDetails implements PaymentMethodDetails
{
    /**
     * @var Carbon|null
     */
    private $datetimeLocal;

    /**
     * @var SetupToken|null
     */
    private $setupToken;

    /**
     * @var VaultToken|null
     */
    private $vaultToken;

    /**
     * @param array $details
     * @return BancontactPaymentMethodDetails
     */
    public static function fromArray(array $details)
    {
        return new static(
            array_key_exists('datetime_local', $details) ? new Carbon($details['datetime_local']) : null,
            array_key_exists('setup_token', $details) ? SetupToken::fromString($details['setup_token']) : null,
            array_key_exists('vault_token', $details) ? VaultToken::fromString($details['vault_token']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'datetime_local' => ($this->datetimeLocal() !== null) ? $this->datetimeLocal()->toIso8601String() : null,
            'setup_token' => ($this->setupToken() !== null) ? $this->setupToken()->toString() : null,
            'vault_token' => ($this->vaultToken() !== null) ? $this->vaultToken()->toString() : null
        ];
    }

    /**
     * @return Carbon|null
     */
    public function datetimeLocal()
    {
        return $this->datetimeLocal;
    }

    /**
     * @return SetupToken|null
     */
    public function setupToken()
    {
        return $this->setupToken;
    }

    /**
     * @return VaultToken|null
     */
    public function vaultToken()
    {
        return $this->vaultToken;
    }

    /**
     * @param Carbon $datetimeLocal
     * @param SetupToken $setupToken
     * @param VaultToken $vaultToken
     */
    private function __construct(
        Carbon $datetimeLocal = null,
        SetupToken $setupToken = null,
        VaultToken $vaultToken = null
    ) {
        $this->datetimeLocal = $datetimeLocal;
        $this->setupToken = $setupToken;
        $this->vaultToken = $vaultToken;
    }
}
