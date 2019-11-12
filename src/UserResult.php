<?php

namespace Davidhsianturi\Compass;

use JsonSerializable;

class UserResult implements JsonSerializable
{
    /**
     * The user API key.
     *
     * @var string
     */
    public $apiKey;

    /**
     * Create a new user result instance.
     *
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get the array representation of the user.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'apiKey' => $this->apiKey,
        ];
    }
}
