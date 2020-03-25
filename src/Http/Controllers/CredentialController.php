<?php

namespace Davidhsianturi\Compass\Http\Controllers;

use Davidhsianturi\Compass\Contracts\AuthenticatorRepository;

class CredentialController
{
    /**
     * Get a new credential of users.
     *
     * @param  AuthenticatorRepository  $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(AuthenticatorRepository $auth)
    {
        return response()->json([
            'data' => $auth->credentials(),
        ]);
    }
}
