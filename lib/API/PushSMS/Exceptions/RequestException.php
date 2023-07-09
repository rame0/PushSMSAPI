<?php

namespace rame0\API\PushSMS\Exceptions;

use Exception;
use rame0\API\PushSMS\Statuses;
use Throwable;

class RequestException extends Exception
{
    public function __construct(int $code = 0, Throwable $previous = null)
    {
        parent::__construct(Statuses::getMessage($code), $code, $previous);
    }
}
