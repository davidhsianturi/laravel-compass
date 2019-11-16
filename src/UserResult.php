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
     * The user identifier key.
     *
     * @var string
     */
    public $identifierKey;

    /**
     * Create a new user result instance.
     *
     * @param string $apiKey
     * @param string $identifierKey
     */
    public function __construct(string $apiKey, string $identifierKey)
    {
        $this->apiKey = $apiKey;
        $this->identifierKey = $identifierKey;
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
            'identifierKey' => $this->identifierKey,
        ];
    }
}
