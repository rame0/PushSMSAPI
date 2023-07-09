<?php

namespace rame0\API\PushSMS\Endpoints;

use rame0\API\PushSMS\Endpoints\Interfaces\EndpointInterface;

abstract class Base implements EndpointInterface
{
    /**
     * @var array $params
     */
    protected array $params = [];

    /**
     * @return string
     *
     * Примеры: delivery; bulk_delivery
     */
    public function getEndpoint(): string
    {
        $classname_arr = explode('\\', static::class);
        return strtolower(preg_replace('/(\w)([A-Z]+)/', "$1_$2", end($classname_arr)));
    }

    public function getParams(): array
    {
        $params = array_filter($this->params);
        return ['body' => json_encode($params)];
    }

}
