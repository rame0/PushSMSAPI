<?php

/**
 * Класс для отправки одного сообщения
 *
 * @package rame0\API\PushSMS
 *
 * @link https://docs.pushsms.ru/#/delivery
 */

namespace rame0\API\PushSMS\Endpoints;

class Delivery extends BaseDelivery
{

    /**
     * @param string $text Текст сообщения. Стандартная длина для одного сообщения 160 символов для латиницы или
     *                     70 для не латиницы.
     * @param string $phone Телефон получателя сообщения. Международный формат 79991112233, для российских номеров
     *                      доступен 89991112233
     */
    public function __construct(
        string $text,
        string $phone
    )
    {
        $this->params = [
            'text' => $text,
            'phone' => $phone
        ];
    }

    /**
     * @param string $callback_url URL-адрес, на который будет автоматически высылаться информация при обновлении
     *                             статуса отправки. Структура: https://docs.pushsms.ru/#/callback_url.
     */
    public function setCallbackUrl(string $callback_url)
    {
        $this->params['callback_url'] = $callback_url;

        return $this;
    }

    /**
     * @param string $external_id Идентификатор сообщения. Генерируется на стороне клиента и необходим в уникальном
     *                            виде для использования идемпотентности (https://docs.pushsms.ru/#/idempotency).
     */
    public function setExternalId(string $external_id)
    {
        $this->params['external_id'] = $external_id;

        return $this;
    }

    /**
     * @param string $priority Приоритет отправки сообщения. Доступные значения: "high", "medium" и "low".
     *                         При отсутствии параметра оптимальное значение определяется автоматически.
     */
    public function setPriority(string $priority)
    {
        $this->params['priority'] = $priority;

        return $this;
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
