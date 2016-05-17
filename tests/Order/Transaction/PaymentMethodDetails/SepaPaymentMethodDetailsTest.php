<?php

namespace GingerPayments\Payment\Tests\Order\Transaction\PaymentMethodDetails;

use GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\SepaPaymentMethodDetails;

final class SepaPaymentMethodDetailsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldCreateFromAnArray()
    {
        $this->assertInstanceOf(
            'GingerPayments\Payment\Order\Transaction\PaymentMethodDetails\SepaPaymentMethodDetails',
            SepaPaymentMethodDetails::fromArray([])
        );
    }

    /**
     * @test
     */
    public function itShouldConvertToArray()
    {
        $this->assertEquals(
            [
                'consumer_name' => null,
                'consumer_address' => null,
                'consumer_city' => null,
                'consumer_country' => null,
                'consumer_iban' => null,
                'consumer_bic' => null,
                'reference' => null
            ],
            SepaPaymentMethodDetails::fromArray([])->toArray()
        );
    }
}
