<?php

namespace Davidhsianturi\Compass\Contracts;

interface UsersRepository
{
    /**
     * Return all the users from storage.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\UserResult[]
     */
    public function get();
}
