<?php

namespace rame0\API\PushSMS\Endpoints\Interfaces;

interface EndpointInterface
{
    /**
     * @return string
     *
     * GET/POST/PATCH/DELETE
     */
    public function getMethod(): string;

    /**
     * @return string
     *
     * Ссылка на действие базовой URL
     */
    public function getEndpoint(): string;

    /**
     * @return array
     *
     * Получить параметры для отправки
     */
    public function getParams(): array;

    /**
     * Валидация отправляемых данных
     */
    public function validateParams();
}
