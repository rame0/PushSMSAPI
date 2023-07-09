# PHP wrapper for Push SMS API

## Installation

```shell
composer require rame0/pushsms-api
```

## Usage

### Bulk SMS Delivery

```php
<?php

use rame0\API\PushSMS\PushSMS;
use rame0\API\PushSMS\Endpoints\BulkDelivery;
use rame0\API\PushSMS\Types\DispatchRoutingTypes;

// Initialize client
$client = new PushSMS('<API_TOKEN>');
// Initialize endpoint
$endpoint = new BulkDelivery(
    'Your SMS message',
    ['+71234567890', '+71234567891', '+71234567892'],
);
// Set endpoint parameters
$endpoint
    ->setSenderName($_ENV['SENDER_NAME'])
    ->setDispatchRouting([
        DispatchRoutingTypes::WHATSAPP,
        DispatchRoutingTypes::TELEGRAM_BOT,
        DispatchRoutingTypes::TELEGRAM_NUMBER
    ]);


$response = $client->request($endpoint);
```

### Single SMS Delivery

```php
<?php

use rame0\API\PushSMS\PushSMS;
use rame0\API\PushSMS\Endpoints\Delivery;
use rame0\API\PushSMS\Types\DispatchRoutingTypes;

// Initialize client
$client = new PushSMS('<API_TOKEN>');
// Initialize endpoint
$endpoint = new Delivery(
    'Your SMS message',
    '+71234567890',
);
// Set endpoint parameters
$endpoint
    ->setSenderName($_ENV['SENDER_NAME'])
    ->setDispatchRouting([
        DispatchRoutingTypes::WHATSAPP,
        DispatchRoutingTypes::TELEGRAM_BOT,
        DispatchRoutingTypes::TELEGRAM_NUMBER
    ]);


$response = $client->request($endpoint);
```

## Run tests

* Run `composer install` to install all dependencies
* Copy `.env.example` to `.env` and set the correct values
* Run `phpunit` to run all tests


