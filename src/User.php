<?php

namespace Rojtjo\SentinelGuard;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends EloquentUser implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
}
