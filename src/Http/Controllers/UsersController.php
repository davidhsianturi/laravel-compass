<?php

namespace Davidhsianturi\Compass\Http\Controllers;

use Davidhsianturi\Compass\Contracts\UsersRepository;

class UsersController
{
    /**
     * The users repository.
     *
     * @var \Davidhsianturi\Compass\Contracts\UsersRepository
     */
    protected $users;

    /**
     * Create a new UsersController instance.
     *
     * @param  \Davidhsianturi\Compass\Contracts\UsersRepository  $users
     */
    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    /**
     * List the authenticated users.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'data' => $this->users->get(),
        ]);
    }
}
