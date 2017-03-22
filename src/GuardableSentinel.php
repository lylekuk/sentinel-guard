<?php

namespace Rojtjo\SentinelGuard;

use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Users\UserInterface;

class GuardableSentinel extends Sentinel
{
    /**
     * Cycles through all the registered checkpoints for a user. Checkpoints
     * may throw their own exceptions, however, if just one returns false,
     * the cycle fails.
     *
     * @param  string  $method
     * @param  \Cartalyst\Sentinel\Users\UserInterface  $user
     * @param  bool  $halt
     * @return bool
     */
    public function doCycleCheckpoints($method, UserInterface $user = null, $halt = true)
    {
        return $this->cycleCheckpoints($method, $user, $halt);
    }
}
