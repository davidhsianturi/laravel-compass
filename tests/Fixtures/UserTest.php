<?php

namespace Davidhsianturi\Compass\Tests\Fixtures;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User;

class UserTest extends User
{
    use HasApiTokens;

    protected $table = 'users';
}
