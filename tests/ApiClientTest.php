<?php

namespace Ginger\Tests;

use Ginger\ApiClient;
use Ginger\HttpClient\HttpException;
use Ginger\Tests\HttpClient\MockHttpClient;

final class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockHttpClient
     */
    private $httpClient;

    /**
     * @var ApiClient
     */
    private $apiClient;

    public function setUp()
    {
        $this->httpClient = new MockHttpClient();
        $this->apiClient = new ApiClient($this->httpClient);
    }

    public function test_it_gets_ideal_issuers()
    {
        $expectedIssuers = [
            [
                'id' => 'INGBNL2A',
                'list_type' => 'Deutschland',
                'name' => 'Issuer Simulation V3 - ING'
            ],
            [
                'id' => 'RABONL2U',
                'list_type' => 'Deutschland',
                'name' => 'Issuer Simulation V3 - RABO'
            ]
        ];

        $this->httpClient->setResponseToReturn(json_encode($expectedIssuers));

        $issuers = $this->apiClient->getIdealIssuers();

        $this->assertEquals(['GET', '/ideal/issuers', [], null], $this->httpClient->lastRequestData());
        $this->assertEquals($expectedIssuers, $issuers);
    }

    public function test_it_gets_an_order()
    {
        $expectedOrder = [
            'id' => 'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
            'transactions' => [
                [
                    'id' => 'ddc76c84-3fc2-4a16-85b9-a895f6bdc696',
                    'amount' => 995
                ]
            ]
        ];

        $this->httpClient->setResponseToReturn(json_encode($expectedOrder));

        $order = $this->apiClient->getOrder('fcbfdd3a-ea2c-4240-96b2-613d49b79a55');

        $this->assertEquals(
            ['GET', '/orders/fcbfdd3a-ea2c-4240-96b2-613d49b79a55', [], null],
            $this->httpClient->lastRequestData()
        );
        $this->assertEquals($expectedOrder, $order);
    }

    public function test_it_creates_an_order()
    {
        $expectedOrder = [
            'amount' => 995,
            'currency' => 'EUR',
            'description' => 'My amazing order',
            'merchant_order_id' => 'my-custom-id-7131b462',
            'return_url' => 'https://www.example.com',
            'webhook_url' => 'https://www.example.com/hook',
            'customer' => ['first_name' => 'John', 'last_name' => 'Doe'],
            'extra' => ['my-custom-data' => 'Foobar'],
            'transactions' => [
                [
                    'payment_method' => 'ideal',
                    'payment_method_details' => ['issuer_id' => 'INGBNL2A'],
                    'expiration_period' => 'PT10M'
                ]
            ]
        ];

        $this->httpClient->setResponseToReturn(json_encode($expectedOrder));

        $order = $this->apiClient->createOrder($expectedOrder);

        $this->assertEquals(
            [
                'POST',
                '/orders',
                ['Content-Type' => 'application/json'],
                json_encode($expectedOrder)
            ],
            $this->httpClient->lastRequestData()
        );
        $this->assertEquals($expectedOrder, $order);
    }

    public function test_it_updates_an_order()
    {
        $expectedOrder = [
            'id' => 'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
            'amount' => 995,
            'currency' => 'EUR',
            'description' => 'My new description',
            'merchant_order_id' => 'my-custom-id-7131b462',
            'return_url' => 'https://www.example.com',
            'webhook_url' => 'https://www.example.com/hook',
            'customer' => ['first_name' => 'John', 'last_name' => 'Doe'],
            'extra' => ['my-custom-data' => 'Foobar'],
            'transactions' => [
                [
                    'payment_method' => 'ideal',
                    'payment_method_details' => ['issuer_id' => 'INGBNL2A'],
                    'expiration_period' => 'PT10M'
                ]
            ]
        ];

        $this->httpClient->setResponseToReturn(json_encode($expectedOrder));

        $order = $this->apiClient->updateOrder(
            'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
            ['description' => 'My new description']
        );

        $this->assertEquals(
            [
                'PUT',
                '/orders/fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
                ['Content-Type' => 'application/json'],
                json_encode(['description' => 'My new description'])
            ],
            $this->httpClient->lastRequestData()
        );
        $this->assertEquals($expectedOrder, $order);
    }

    public function test_it_refunds_an_order()
    {
        $expectedOrder = [
            'id' => 'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
            'transactions' => [
                [
                    'id' => 'ddc76c84-3fc2-4a16-85b9-a895f6bdc696',
                    'amount' => 995
                ]
            ]
        ];

        $this->httpClient->setResponseToReturn(json_encode($expectedOrder));

        $order = $this->apiClient->refundOrder(
            'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
            ['amount' => 123, 'description' => 'My refund']
        );

        $this->assertEquals(
            [
                'POST',
                '/orders/fcbfdd3a-ea2c-4240-96b2-613d49b79a55/refunds',
                ['Content-Type' => 'application/json'],
                json_encode(['amount' => 123, 'description' => 'My refund'])
            ],
            $this->httpClient->lastRequestData()
        );
        $this->assertEquals($expectedOrder, $order);
    }

    public function test_it_captures_an_order_transaction()
    {
        $this->apiClient->captureOrderTransaction(
            'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
            'ca3dfa6f-3dd3-4942-a358-b6852a407333'
        );

        $this->assertEquals(
            [
                'POST',
                sprintf(
                    '/orders/%s/transactions/%s/captures/',
                    'fcbfdd3a-ea2c-4240-96b2-613d49b79a55',
                    'ca3dfa6f-3dd3-4942-a358-b6852a407333'
                ),
                [],
                null
            ],
            $this->httpClient->lastRequestData()
        );
    }

    public function test_it_gets_an_currency_list()
    {
        $expectedCurrency = [
            "payment_methods" => [
                "afterpay" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "amex" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "apple-pay" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "bancontact" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "bank-transfer" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "credit-card" => [
                    "currencies" => [
                        "EUR",
                        "USD"
                    ]
                ],
                "google-pay" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "ideal" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "klarna-direct-debit" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "klarna-pay-later" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "klarna-pay-now" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "payconiq" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "paypal" => [
                    "currencies" => [
                        "EUR"
                    ]
                ],
                "sofort" => [
                    "currencies" => [
                        "EUR"
                    ]
                ]
            ]
        ];

        $this->httpClient->setResponseToReturn(json_encode($expectedCurrency));
        $currencyList = $this->apiClient->getCurrencyList();

        $this->assertEquals(
            [
                'GET',
                '/merchants/self/projects/self/currencies',
                [],
                null
            ],
            $this->httpClient->lastRequestData()
        );

        $this->assertEquals($currencyList,$expectedCurrency);
    }

    public function test_it_throws_an_exception_on_http_client_error()
    {
        $this->httpClient->setExceptionToThrow(new HttpException('Whoops!'));

        $this->setExpectedException(ApiClient\HttpRequestFailure::class);
        $this->apiClient->getIdealIssuers();
    }

    public function test_it_throws_an_exception_on_json_decode_error()
    {
        $this->httpClient->setResponseToReturn('definately not json');

        $this->setExpectedException(ApiClient\JsonDecodeFailure::class);
        $this->apiClient->getIdealIssuers();
    }

    public function test_it_throws_an_exception_on_server_error()
    {
        $this->httpClient->setResponseToReturn(
            json_encode(
                ['error' => ['status' => '503', 'type' => 'ConnectionError', 'value' => 'The server made a boo-boo']]
            )
        );

        $this->setExpectedException(ApiClient\ServerError::class);
        $this->apiClient->getIdealIssuers();
    }
}
