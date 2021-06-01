# Ginger PHP bindings

[![Build Status](https://travis-ci.org/gingerpayments/ginger-php.svg)](https://travis-ci.org/gingerpayments/ginger-php)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/gingerpayments/ginger-php/blob/master/LICENSE)

## Requirements

* PHP 5.6 or later
* JSON PHP extension
* cURL PHP extension

## Installation

You can install the PHP bindings using composer:

```
composer require gingerpayments/ginger-php
```

You can also use the PHP bindings without using Composer by registering an autoloader function:

```php
spl_autoload_register(
    function($fqcn) {
        if (substr($fqcn, 0, 7) === 'Ginger\\') {
            return;
        }

        $pathToGinger = __DIR__ . '/relative/path/to/ginger';
        $class = substr($fqcn, 7);
        $path = sprintf('%s/src/%s.php', $pathToGinger, str_replace('\\', '/', $class));

        if (is_file($path)) {
            require_once $path;
        }
    }
);
```

Or you could just include the composer generated autoloader:

```php
require_once 'ginger-php/vendor/autoload.php';
```

## Getting started

First create a new API client with your API key and API endpoint:

```php
use \Ginger\Ginger;

$client = Ginger::createClient('https://api.example.com', 'your-api-key');
```

### Initiating a payment

You can start a new payment by creating a new order:

```php
$order = $client->createOrder(
    [
        'merchant_order_id' => 'my-custom-order-id-12345',
        'currency' => 'EUR',
        'amount' => 2500, // Amount in cents
        'description' => 'Purchase order 12345',
        'return_url' => 'https://www.example.com',
        'transactions' => [
            [
                'payment_method' => 'credit-card'
            ]
        ]
    ]
);
```

Once you've created your order, a transaction is created and associated with it. You will need to redirect the user to
the transaction's payment URL, which you can retrieve as follows:

```php
$paymentUrl = $order['order_url'];
```

It is also recommended that you store the order's ID somewhere, so you can retrieve information about it later:

```php
$orderId = $order['id'];
```

There is a lot more data related to an order. Please refer to the API documentation provided by your PSP to learn more
about the various payment methods and options.

### Getting an order

If you want to retrieve an existing order, use the `getOrder` method on the client:

```php
$order = $client->getOrder($orderId);
```

This will return an associative array with all order information.

### Updating an order

Some fields are not read-only and you are able to update them after order has been created. You can do this using
the `updateOrder` method on the client:

```php
$order = $client->getOrder($orderId);
$order['description'] = "New Order Description";
$updatedOrder = $client->updateOrder($orderId, $order);
```

### Initiating a refund

You can refund an existing order by using the `refundOrder` method on the client:

```php
$refundOrder = $client->refundOrder($orderId, ['amount' => 123, 'description' => 'My refund']);
```

### Capturing a transaction of an order

You can initiate a capture of an order's transaction by using the `captureOrderTransaction` method:

```
$client->captureOrderTransaction($orderId, $transactionId);
```

### Getting the iDEAL issuers

When you create an order with the iDEAL payment method, you need to provide an issuer ID. The issuer ID is an identifier
of the bank the user has selected. You can retrieve all possible issuers by using the `getIdealIssuers` method:

```php
$issuers = $client->getIdealIssuers();
```

You can then use this information to present a list to the user of possible banks to choose from.

### Getting the currency list

You can use the following request to retrieve a list of available currencies in ISO 4217 format.

```php
$issuers = $client->getCurrencyList();
```

For each available payment method for your account, you receive a list with available ISO 4217 currencies.

### Custom requests

You can send any request that the API accepts using the `send` method. E.g. instead of using the `createOrder` method
you could also use the following:

```php
$result = $client->send(
    'POST', // Request method
    '/orders', // API path
    $orderData // Data to send with the request; optional
);
```

The `$result` variable would then contain the decoded JSON returned by the API.

## Using a different CA bundle

If you need to use a different CA bundle than the one that comes with your system or cURL installation, you can
provide custom cURL options indicating the location of your CA bundle as follows:

```php
use \Ginger\Ginger;

$client = Ginger::createClient(
    'https://api.example.com',
    'your-api-key',
    [
        CURLOPT_CAINFO => '/path/to/ca-bundle.pem'
    ]
);
```

For more information on which cURL options to use, refer to the PHP cURL documentation.

## Custom HTTP client

This library ships with its own minimal HTTP client for compatibility reasons. If you would like to use a different HTTP
client, you can do so by implementing the `Ginger\HttpClient\HttpClient` interface and then constructing your own
client:

```php
$myHttpClient = new MyHttpClient();
$client = new Ginger\ApiClient($myHttpClient);
```

Make sure your HTTP client prefixes the endpoint URL and API version to all requests, and uses HTTP basic auth to
authenticate with the API using your API key.

## API documentation

For the complete API documentation please prefer to the resources provided by your PSP.
