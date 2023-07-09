<?php

/**
 * Класс для отправки одного сообщения
 *
 * @package rame0\API\PushSMS
 *
 * @link https://docs.pushsms.ru/#/delivery
 */

namespace rame0\API\PushSMS\Endpoints;

class BulkDelivery extends BaseDelivery
{

    /**
     * @param string $text Текст сообщения. Стандартная длина для одного сообщения 160 символов для латиницы или
     *                     70 для не латиницы.
     * @param array $phones_numbers Телефоны получателя сообщения. Международный формат 79991112233, для российских
     *                               номеров доступен 89991112233. Пример: +79991234567, 84956785422, +79851323233
     */

    public function __construct(
        string $text,
        array  $phones_numbers
    )
    {
        $this->params = [
            'text' => $text,
            'phones_numbers' => $phones_numbers
        ];
    }


    /**
     * @return string
     */
    public function getMethod(): string
    {
        return 'POST';
    }
}
