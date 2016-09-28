# Ginger Payments PHP Bindings

[![Build Status](https://travis-ci.org/gingerpayments/ginger-php.svg)](https://travis-ci.org/gingerpayments/ginger-php)
[![Code Coverage](https://scrutinizer-ci.com/g/gingerpayments/ginger-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/gingerpayments/ginger-php/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gingerpayments/ginger-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gingerpayments/ginger-php/?branch=master)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/gingerpayments/ginger-php/blob/master/LICENSE)

You can sign up for a Ginger Payments account at https://www.gingerpayments.com

## Requirements

* PHP 5.4 or later.

## Installation

You can install the PHP bindings using composer:

```
composer require gingerpayments/ginger-php
```

You can also use the PHP bindings without using Composer by registering an autoloader function:

```php
spl_autoload_register(function($class) {
    $prefix = 'GingerPayments\\Payment\\';

    if (!substr($class, 0, 23) === $prefix) {
        return;
    }

    $class = substr($class, strlen($prefix));
    $location = __DIR__ . 'path/to/gingerpayments/ginger-php/src/' . str_replace('\\', '/', $class) . '.php';

    if (is_file($location)) {
        require_once($location);
    }
});
```

Or you could just include the composer generated autoloader:

```php
include_once 'ginger-php/vendor/autoload.php';
```

## Getting started

First create a new API client with your API key:

```php
use \GingerPayments\Payment\Ginger;

$client = Ginger::createClient('your-api-key');
```

If your PHP.ini *curl.cainfo* is not set and you get the **cURL: code 60 error** then use `useBundledCA` flag:

```php
$client->useBundledCA();
```

### Create a new order

Creating a new order is easy:

```php
$order = $client->createOrder(
    2500,                           // The amount in cents
    'EUR',                          // The currency
    'ideal',                        // The payment method
    ['issuer_id' => 'INGBNL2A'],    // Extra details required for this payment method
    'A great order',                // A description (optional)
    'order-234192',                 // Your identifier for the order (optional)
    'http://www.example.com',       // The return URL (optional)
    'PT15M'                         // The expiration period in ISO 8601 format (optional)
);
```

You can also use the `createIdealOrder` method to create a new order using the iDEAL payment method:

```php
$order = $client->createIdealOrder(
    2500,                           // The amount in cents
    'EUR',                          // The currency
    'INGBNL2A',                     // The iDEAL issuer
    'A great order',                // A description (optional)
    'order-234192',                 // Your identifier for the order (optional)
    'http://www.example.com',       // The return URL (optional)
    'PT15M'                         // The expiration period in ISO 8601 format (optional)
);
```

Or the `createCreditCardOrder` method:

```php
$order = $client->createCreditCardOrder(
    2500,                           // The amount in cents
    'EUR',                          // The currency
    'A great order',                // A description (optional)
    'order-234192',                 // Your identifier for the order (optional)
    'http://www.example.com',       // The return URL (optional)
    'PT15M'                         // The expiration period in ISO 8601 format (optional)
);
```

Or the `createSepaOrder` method if you need to create a Bank Transfer order:

```php
$order = $client->createSepaOrder(
    2500,                           // The amount in cents
    'EUR',                          // The currency
    [],                             // Array of payment method details
    'Bank Transfer order',          // A description (optional)
    'order-234192',                 // Your identifier for the order (optional)
    'http://www.example.com',       // The return URL (optional)
    'PT15M'                         // The expiration period in ISO 8601 format (optional)
);
```

Or the `createSofortOrder` method if you need to create SOFORT order:

```php
$order = $client->createSofortOrder(
    2500,                           // The amount in cents
    'EUR',                          // The currency
    [],                             // Array of payment method details
    'SOFORT order',                 // A description (optional)
    'order-234192',                 // Your identifier for the order (optional)
    'http://www.example.com',       // The return URL (optional)
    'PT15M'                         // The expiration period in ISO 8601 format (optional)
);
```

Or the `createBancontactOrder` method if you need to create a Bancontact order:

```php
$order = $client->createBancontactOrder(
    2500,                           // The amount in cents
    'EUR',                          // The currency
    'Bancontact order',             // A description (optional)
    'order-234192',                 // Your identifier for the order (optional)
    'http://www.example.com',       // The return URL (optional)
    'PT15M'                         // The expiration period in ISO 8601 format (optional)
);
```

Once you've created your order, a transaction is created and associated with it. You will need to redirect the user to
the transaction's payment URL, which you can retrieve as follows:

```php
$paymentUrl = $order->firstTransactionPaymentUrl();
```

It is also recommended that you store the order's ID somewhere, so you can retrieve information about it later:

```php
$orderId = $order->id();
```

You can also access other information related to the order. Inspect the `GingerPayments\Payment\Order` class for more
information. If you just want everything as a simple array, you can also use the `Order::toArray` method.

### Getting an order

If you want to retrieve an existing order, use the `getOrder` method on the client:

```php
$order = $client->getOrder($orderId);
```

You can iterate over all transactions in the order as follows:

```php
foreach ($order->transactions() as $transaction) {
    $transaction->status()->isCompleted(); // Check the status
    $transaction->amount(); // How much paid
}
```
You can access other information related to order transactions as well. Inspect the
`GingerPayments\Payment\Order\Transaction` class for more information.

### Updating an order

Some fields in Ginger Payments API are not read-only and you are able to update them after order has been created using `updateOrder` method:
```php
$order = $client->getOrder($orderId);
$order->description("New Order Description");
$updatedOrder->updateOrder($order);
```
After successful PUT request API will return updated order data:
```php
var_dump($updatedOrder->toArray());
```

### Getting the iDEAL issuers

When you create an order with the iDEAL payment method, you need to provide an issuer ID. The issuer ID is an identifier
of the bank the user has selected. You can retrieve all possible issuers by using the `getIdealIssuers` method:

```php
$issuers = $client->getIdealIssuers();
```

You can then use this information to present a list to the user of possible banks to choose from.

## API documentation

Full API documentation is available [here](https://www.gingerpayments.com/api).

## Tests

In order to run the tests first install PHPUnit via Composer:

```
composer install --dev
```

Then run the test suite:

```
./vendor/bin/phpunit
```