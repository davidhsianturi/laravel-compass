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
     * The user attribute key.
     *
     * @var string
     */
    public $attributeKey;

    /**
     * Create a new user result instance.
     *
     * @param  string  $apiKey
     * @param  string  $attributeKey
     */
    public function __construct(string $apiKey, string $attributeKey)
    {
        $this->apiKey = $apiKey;
        $this->attributeKey = $attributeKey;
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
            'attributeKey' => $this->attributeKey,
        ];
    }
}
