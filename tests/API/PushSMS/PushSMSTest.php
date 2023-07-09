<?php

namespace API\PushSMS;

use Dotenv\Dotenv;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use rame0\API\PushSMS\Endpoints\BulkDelivery;
use rame0\API\PushSMS\Endpoints\Delivery;
use rame0\API\PushSMS\Exceptions\RequestException;
use rame0\API\PushSMS\PushSMS;
use rame0\API\PushSMS\Types\DispatchRoutingTypes;

class PushSMSTest extends TestCase
{
    private PushSMS $_api;


    public function __construct()
    {
        parent::__construct();
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $this->_api = new PushSMS($_ENV['API_TOKEN']);
    }

    /**
     * @return void
     * @throws GuzzleException
     * @throws RequestException
     */
    public function testBulkDelivery()
    {
        $endpoint = new BulkDelivery(
            'test',
            explode(',', $_ENV['PHONES'] ?? ''),
        );

        $endpoint
            ->setSenderName($_ENV['SENDER_NAME'])
            ->setDispatchRouting([
                DispatchRoutingTypes::WHATSAPP,
                DispatchRoutingTypes::TELEGRAM_BOT,
                DispatchRoutingTypes::TELEGRAM_NUMBER
            ]);

        $response = $this->_api->request($endpoint);
        $this->assertEquals(200, $response->meta->code);
    }

    /**
     * @return void
     * @throws GuzzleException
     * @throws RequestException
     */
    public function testDelivery()
    {
        $endpoint = new Delivery(
            'test',
            $_ENV['PHONE'] ?? '',

        );

        $endpoint
            ->setSenderName($_ENV['SENDER_NAME'])
            ->setDispatchRouting([
                DispatchRoutingTypes::WHATSAPP,
                DispatchRoutingTypes::TELEGRAM_BOT,
                DispatchRoutingTypes::TELEGRAM_NUMBER
            ]);

        $response = $this->_api->request($endpoint);
        $this->assertEquals(200, $response->meta->code);
    }

}
