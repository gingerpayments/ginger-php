<?php

namespace GingerPayments\Payment\Tests;

use GingerPayments\Payment\Client;
use GingerPayments\Payment\Common\ArrayFunctions;
use GingerPayments\Payment\Order;
use GuzzleHttp\Exception\ClientException as HttpClientException;
use Mockery as m;

final class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    private $httpResponse;

    /**
     * @var \Mockery\MockInterface
     */
    private $httpClient;

    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->httpResponse = m::mock('GuzzleHttp\Message\ResponseInterface');
        $this->httpClient = m::mock('GuzzleHttp\Client');
        $this->client = new Client($this->httpClient);
    }

    /**
     * @test
     */
    public function itShouldGetIdealIssuers()
    {
        $this->httpClient->shouldReceive('get')
            ->once()
            ->with('ideal/issuers/')
            ->andReturn($this->httpResponse);

        $this->httpResponse->shouldReceive('json')
            ->once()
            ->andReturn(
                [
                    [
                        'id' => 'ABNANL2A',
                        'name' => 'ABN AMRO Bank',
                        'list_type' => 'Nederland'
                    ]
                ]
            );

        $this->assertInstanceOf(
            'GingerPayments\Payment\Ideal\Issuers',
            $this->client->getIdealIssuers()
        );
    }

    /**
     * @test
     */
    public function itShouldCatchHttpClientExceptionsWhenGettingIdealIssuers()
    {
        $this->httpClient->shouldReceive('get')
            ->once()
            ->with('ideal/issuers/')
            ->andThrow(new HttpClientException('Something happened', m::mock('GuzzleHttp\Message\Request')));

        $this->setExpectedException('GingerPayments\Payment\Client\ClientException');
        $this->client->getIdealIssuers();
    }

    /**
     * @test
     */
    public function itShouldCreateAnOrder()
    {
        $order = Order::create(
            1234,
            'EUR',
            'credit-card',
            [],
            'A nice description',
            'my-order-id',
            'http://www.example.com',
            'PT10M'
        );

        $this->httpClient->shouldReceive('post')
            ->once()
            ->with(
                'orders/',
                m::on(
                    function (array $options) use ($order) {
                        $this->assertEquals(3, $options['timeout']);
                        $this->assertEquals('application/json', $options['headers']['Content-Type']);
                        $this->assertEquals(
                            ArrayFunctions::withoutNullValues($order->toArray()),
                            json_decode($options['body'], true)
                        );
                        return true;
                    }
                )
            )
            ->andReturn($this->httpResponse);

        $this->httpResponse->shouldReceive('json')
            ->once()
            ->andReturn(ArrayFunctions::withoutNullValues($order->toArray()));

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order',
            $this->client->createOrder(
                1234,
                'EUR',
                'credit-card',
                [],
                'A nice description',
                'my-order-id',
                'http://www.example.com',
                'PT10M'
            )
        );
    }

    /**
     * @test
     */
    public function itShouldCreateACreditCardOrder()
    {
        $order = Order::create(
            1234,
            'EUR',
            'credit-card',
            [],
            'A nice description',
            'my-order-id',
            'http://www.example.com',
            'PT10M'
        );

        $this->httpClient->shouldReceive('post')
            ->once()
            ->with(
                'orders/',
                m::on(
                    function (array $options) use ($order) {
                        $this->assertEquals(3, $options['timeout']);
                        $this->assertEquals('application/json', $options['headers']['Content-Type']);
                        $this->assertEquals(
                            ArrayFunctions::withoutNullValues($order->toArray()),
                            json_decode($options['body'], true)
                        );
                        return true;
                    }
                )
            )
            ->andReturn($this->httpResponse);

        $this->httpResponse->shouldReceive('json')
            ->once()
            ->andReturn(ArrayFunctions::withoutNullValues($order->toArray()));

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order',
            $this->client->createCreditCardOrder(
                1234,
                'EUR',
                'A nice description',
                'my-order-id',
                'http://www.example.com',
                'PT10M'
            )
        );
    }

    /**
     * @test
     */
    public function itShouldCreateAnIdealOrder()
    {
        $order = Order::create(
            1234,
            'EUR',
            'ideal',
            ['issuer_id' => 'ABNANL2A'],
            'A nice description',
            'my-order-id',
            'http://www.example.com',
            'PT10M'
        );

        $this->httpClient->shouldReceive('post')
            ->once()
            ->with(
                'orders/',
                m::on(
                    function (array $options) use ($order) {
                        $this->assertEquals(3, $options['timeout']);
                        $this->assertEquals('application/json', $options['headers']['Content-Type']);
                        $this->assertEquals(
                            ArrayFunctions::withoutNullValues($order->toArray()),
                            json_decode($options['body'], true)
                        );
                        return true;
                    }
                )
            )
            ->andReturn($this->httpResponse);

        $this->httpResponse->shouldReceive('json')
            ->once()
            ->andReturn(ArrayFunctions::withoutNullValues($order->toArray()));

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order',
            $this->client->createIdealOrder(
                1234,
                'EUR',
                'ABNANL2A',
                'A nice description',
                'my-order-id',
                'http://www.example.com',
                'PT10M'
            )
        );
    }

    /**
     * @test
     */
    public function itShouldCatchHttpClientExceptionsWhenCreatingAnOrder()
    {
        $this->httpClient->shouldReceive('post')
            ->once()
            ->andThrow(new HttpClientException('Something happened', m::mock('GuzzleHttp\Message\Request')));

        $this->setExpectedException('GingerPayments\Payment\Client\ClientException');
        $this->client->createOrder(1234, 'EUR', 'credit-card');
    }

    /**
     * @test
     */
    public function itShouldGetAnOrder()
    {
        $this->httpClient->shouldReceive('get')
            ->once()
            ->with('orders/123456')
            ->andReturn($this->httpResponse);

        $this->httpResponse->shouldReceive('json')
            ->once()
            ->andReturn(
                [
                    'amount' => 1234,
                    'currency' => 'EUR',
                    'transactions' => [
                        ['payment_method' => 'credit-card']
                    ]
                ]
            );

        $this->assertInstanceOf(
            'GingerPayments\Payment\Order',
            $this->client->getOrder('123456')
        );
    }

    /**
     * @test
     */
    public function itShouldThrowAnOrderNotFoundExceptionWhenGettingAnOrder()
    {
        $request = m::mock('GuzzleHttp\Message\Request');
        $response = m::mock('GuzzleHttp\Message\Response');
        $response->shouldReceive('getStatusCode')->andReturn(404);

        $this->httpClient->shouldReceive('get')
            ->once()
            ->andThrow(new HttpClientException('Something happened', $request, $response));

        $this->setExpectedException('GingerPayments\Payment\Client\OrderNotFoundException');
        $this->client->getOrder('123456');
    }

    /**
     * @test
     */
    public function itShouldThrowAClientExceptionWhenGettingAnOrder()
    {
        $request = m::mock('GuzzleHttp\Message\Request');

        $this->httpClient->shouldReceive('get')
            ->once()
            ->andThrow(new HttpClientException('Something happened', $request));

        $this->setExpectedException('GingerPayments\Payment\Client\ClientException');
        $this->client->getOrder('123456');
    }
}
