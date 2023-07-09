<?php

/**
 * Класс для отправки одного сообщения
 *
 * @package rame0\API\PushSMS
 *
 * @link https://docs.pushsms.ru/#/delivery
 */

namespace rame0\API\PushSMS\Endpoints;

use DateInterval;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use rame0\API\PushSMS\Exceptions\ArgumentException;
use rame0\API\PushSMS\Exceptions\ContentLimitException;


abstract class BaseDelivery extends Base
{

    /**
     * @param string $sender_name Имя отправителя. Можно указывать доступные для клиента имена отправителей.
     *                            При отсутствии параметра или невалидности заменяется на “PUSHSMS.RU”
     */
    public function setSenderName(string $sender_name)
    {
        $this->params['sender_name'] = $sender_name;

        return $this;
    }

    /**
     * @param array $dispatch_routing Каналы и последовательность отправки сообщения. Управление функционалом каскадной
     *                                https://docs.pushsms.ru/#/dispatch_routing
     */
    public function setDispatchRouting(array $dispatch_routing)
    {
        $this->params['dispatch_routing'] = $dispatch_routing;

        return $this;
    }

    /**
     * @param DateTimeImmutable|null $scheduled_at
     *                             Дата отложенной отправки должна быть не меньше 1 минуты и не больше 1 месяца с
     *                             текущего момента. Часовой пояс, в котором принимается дата отложенной отправки UTC+0.
     *                             Указывается в формате ГГГГ-ММ-ДД ЧЧ:ММ:СС. Пример: 2021-11-11 20:30:00
     */
    public function setScheduledAt(DateTimeImmutable $scheduled_at)
    {
        $this->params['scheduled_at'] = $scheduled_at;

        return $this;
    }

    /**
     * @param string $utm_mark Метка для маркировки отправок.
     */
    public function setUtmMark(string $utm_mark)
    {
        $this->params['utm_mark'] = $utm_mark;

        return $this;
    }

    /**
     * @throws ArgumentException
     * @throws ContentLimitException
     * @throws Exception
     */
    public function validateParams()
    {
        if (empty($this->params['text'])
            || (empty($this->params['phone']) && empty($this->params['phones_numbers']))
        ) {
            throw new ArgumentException('Не указан один из обязательных параметров: text, phone/phones_numbers');
        }

        if (!empty($this->params['scheduled_at'])) {
            if ($this->params['scheduled_at'] instanceof DateTimeImmutable) {
                /** @var DateInterval $diff */
                $diff = $this->params['scheduled_at']->diff(new DateTimeImmutable("now", new DateTimeZone('UTC')));
                if ($diff->m > 1) {
                    throw new ArgumentException('Параметр scheduled_at должен быть не больше 1 месяца с текущего момента');
                } elseif ($diff->i < 1) {
                    throw new ArgumentException('Параметр scheduled_at должен быть не меньше 1 минуты с текущего момента');
                }
            } else {
                throw new ArgumentException('Параметр scheduled_at должен быть экземпляром DateTimeImmutable');
            }
        }

        if (mb_strlen($this->params['text']) > 800) {
            throw new ContentLimitException('Превышен лимит символов в тексте сообщения (800 символов)');
        }
    }
}
