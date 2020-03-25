<?php

namespace Davidhsianturi\Compass\Authenticators;

use JsonSerializable;

class CredentialResult implements JsonSerializable
{
    /**
     * The credential name.
     *
     * @var string
     */
    public $name;

    /**
     * The plain text version of the token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new credential result instance.
     *
     * @param  string  $name
     * @param  string  $token
     */
    public function __construct(string $name, string $token)
    {
        $this->name = $name;
        $this->token = $token;
    }

    /**
     * Get the array representation of the credential.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'token' => $this->token,
        ];
    }
}
