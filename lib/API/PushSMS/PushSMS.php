<?php

namespace rame0\API\PushSMS;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use rame0\API\PushSMS\Endpoints\Interfaces\EndpointInterface;
use rame0\API\PushSMS\Exceptions\RequestException;

class PushSMS
{
    /** @var string */
    private string $token = '';

    /** @var HttpClient */
    private HttpClient $client;

    protected string $url = 'https://api.pushsms.ru/api/v1/';

    /**
     * PushSMS constructor.
     * @param string $API_TOKEN
     * @param int $timeout
     * @param int $connect_timeout
     */
    public function __construct(string $API_TOKEN, int $timeout = 10, int $connect_timeout = 10)
    {
        if (empty($API_TOKEN)) {
            throw new InvalidArgumentException('API_TOKEN is empty');
        }
        $this->token = $API_TOKEN;

        $this->client = new HttpClient([
            'timeout' => $timeout,
            'connect_timeout' => $connect_timeout,
        ]);
    }

    /**
     * @param EndpointInterface $endpoint
     * @return mixed
     * @throws GuzzleException
     * @throws RequestException
     */
    public function request(EndpointInterface $endpoint)
    {
        $endpoint->validateParams();

        $request_params = $endpoint->getParams();
        if (!isset($request_params['headers'])) {
            $request_params['headers'] = [];
        }
        $request_params['headers']['Authorization'] = 'Bearer ' . $this->token;
        $request_params['headers']['content-type'] = 'application/json';

        $response = $this->client
            ->request($endpoint->getMethod(), $this->url . $endpoint->getEndpoint(), $request_params);

        $response = json_decode((string)$response->getBody(), false);

        if ($response->meta->code !== 200) {
            throw new RequestException((int)$response->meta->code);
        }

        return $response;
    }

}
