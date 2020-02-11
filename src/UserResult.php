<?php

namespace Davidhsianturi\Compass;

use JsonSerializable;

class UserResult implements JsonSerializable
{
    /**
     * The API token.
     *
     * @var string
     */
    public $token;

    /**
     * The user attribute.
     *
     * @var string
     */
    public $userAttribute;

    /**
     * Create a new user result instance.
     *
     * @param  string  $token
     * @param  string  $userAttribute
     */
    public function __construct(string $token, string $userAttribute)
    {
        $this->token = $token;
        $this->userAttribute = $userAttribute;
    }

    /**
     * Get the array representation of the user.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'token' => $this->token,
            'userAttribute' => $this->userAttribute,
        ];
    }
}
