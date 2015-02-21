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
    $order = GingerPayments\Payment\Order::createWithIdeal(
        1234,
        'EUR',
        'INGBNL2A',
        'Order description',
        'merchant-order-id-' . uniqid(),
        'http://example.com'
    );

    $request = $client->createRequest(
        'POST',
        'orders/',
        [
            'timeout' => 3,
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode(
                \GingerPayments\Payment\Common\ArrayFunctions::withoutNullValues(
                    $order->toArray()
                )
            )
        ]
    );
    $response = $client->send($request);

    echo $request . "\n\n";
    echo $response . "\n\n";

    var_dump(\GingerPayments\Payment\Order::fromArray($response->json()));

} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo $e->getMessage() . "\n\n";
    echo $e->getRequest() . "\n";
    if ($e->hasResponse()) {
        echo $e->getResponse() . "\n";
    }
}


