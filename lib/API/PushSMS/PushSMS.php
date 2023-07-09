<?php

namespace rame0\API\PushSMS;

class PushSMS
{
    /** @var string */
    private string $token = '';

    /**
     * PushSMS constructor.
     * @param string $API_TOKEN
     */
    public function __construct(string $API_TOKEN)
    {
        $this->token = $API_TOKEN;
    }

}
