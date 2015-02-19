<?php

require __DIR__ . '/vendor/autoload.php';

$apiKey = $argv[1];

$client = new GuzzleHttp\Client(
    [
        'base_url' => ['https://api.gingerpayments.com/{version}/', ['version' => 'v1']],
        'defaults' => [
            'headers' => ['User-Agent' => 'GingerPayments-php-sdk/0.1.0-dev'],
            'auth' => [$apiKey, '']
        ]
    ]
);

try {
    $order = GingerPayments\Payment\Order\Order::create(1234, 'EUR', 'order-1234567', 'My order description', 'http://example.com');

    $request = $client->createRequest(
        'POST',
        'orders/',
        [
            'timeout' => 3,
            'headers' => ['Content-Type' => 'application/json'],
            'body' => $order->toJson()
        ]
    );
    $response = $client->send($request);
} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo $e->getMessage() . "\n\n";
    echo $e->getRequest() . "\n";
    if ($e->hasResponse()) {
        echo $e->getResponse() . "\n";
    }
}


