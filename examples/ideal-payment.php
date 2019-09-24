<?php

require __DIR__ . '/../vendor/autoload.php';

// Set these to your actual endpoint and API key
$endpoint = getenv('GINGER_ENDPOINT');
$apiKey = getenv('GINGER_API_KEY');

// Get our client
$client = \Ginger\Ginger::createClient($endpoint, $apiKey);

// Get the issuers
var_dump(
    $client->getIdealIssuers()
);

// Create our order, indicating we want an iDEAL payment
$order = $client->createOrder(
    [
        'amount' => 250, // Amount in cents
        'currency' => 'EUR',
        'transactions' => [
            [
                'payment_method' => 'ideal',
                'payment_method_details' => [
                    'issuer_id' => 'INGBNL2A'
                ]
            ]
        ]
    ]
);

// Show the payment URL of the transaction where the user can pay
echo "Payment URL: " . $order['transactions'][0]['payment_url'] . "\n";
