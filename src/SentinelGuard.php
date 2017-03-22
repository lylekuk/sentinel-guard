<?php

namespace Rojtjo\SentinelGuard;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;

class SentinelGuard implements StatefulGuard
{
    use GuardHelpers;

    /**
     * @var Sentinel
     */
    private $sentinel;

    /**
     * @var bool
     */
    private $viaRemember = false;

    /**
     * @param GuardableSentinel $sentinel
     */
    public function __construct(GuardableSentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        if ($this->user !== null) {
            return true;
        }

        $persistences = $this->sentinel->getPersistenceRepository();
        if (! $code = $persistences->check()) {
            return false;
        }

        if (! $user = $persistences->findUserByPersistenceCode($code)) {
            return false;
        }

        $this->viaRemember = true;

        if (! $this->sentinel->doCycleCheckpoints('check', $user)) {
            return false;
        }

        $this->user = $user;

        return true;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        return $this->sentinel->guest();
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        return $this->sentinel->getUser();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        $user = $this->user();

        return $user ? $user->getAuthIdentifier() : null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $users = $this->sentinel->getUserRepository();
        $user = $users->findByCredentials($credentials);

        return $user
            ? $users->validateCredentials($user, $credentials)
            : false;
    }

    /**
     * Set the current user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @return void
     */
    public function setUser(Authenticatable $user)
    {
        $this->sentinel->setUser($user);
    }

    /**
     * Attempt to authenticate a user using the given credentials.
     *
     * @param  array $credentials
     * @param  bool $remember
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        return (bool)$this->sentinel->authenticate($credentials, $remember);
    }

    /**
     * Log a user into the application without sessions or cookies.
     *
     * @param  array $credentials
     * @return bool
     */
    public function once(array $credentials = [])
    {
        return $this->sentinel->stateless($credentials);
    }

    /**
     * Log a user into the application.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  bool $remember
     * @return void
     */
    public function login(Authenticatable $user, $remember = false)
    {
        $this->sentinel->login($user, $remember);
    }

    /**
     * Log the given user ID into the application.
     *
     * @param  mixed $id
     * @param  bool $remember
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function loginUsingId($id, $remember = false)
    {
        $user = $this->sentinel->getUserRepository()->findById($id);
        if (! $user) {
            return false;
        }

        $this->login($user, $remember);

        return $user;
    }

    /**
     * Log the given user ID into the application without sessions or cookies.
     *
     * @param  mixed $id
     * @return bool
     */
    public function onceUsingId($id)
    {
        $user = $this->sentinel->getUserRepository()->findById($id);

        return $user
            ? (bool)$this->sentinel->stateless($user)
            : false;
    }

    /**
     * Determine if the user was authenticated via "remember me" cookie.
     *
     * @return bool
     */
    public function viaRemember()
    {
        return $this->viaRemember;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $this->sentinel->logout();
    }
}
