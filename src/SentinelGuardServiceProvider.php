<?php

namespace Rojtjo\SentinelGuard;

use Cartalyst\Sentinel\Sentinel;
use Illuminate\Auth\AuthManager;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class SentinelGuardServiceProvider extends ServiceProvider
{
    /**
     * @param AuthManager $auth
     */
    public function boot(AuthManager $auth)
    {
        $auth->extend('sentinel', function () {
            return new SentinelGuard(
                $this->app->make(GuardableSentinel::class)
            );
        });
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('sentinel', function ($app) {
            $sentinel = new GuardableSentinel(
                $app['sentinel.persistence'],
                $app['sentinel.users'],
                $app['sentinel.roles'],
                $app['sentinel.activations'],
                $app['events']
            );

            if (isset($app['sentinel.checkpoints'])) {
                foreach ($app['sentinel.checkpoints'] as $key => $checkpoint) {
                    $sentinel->addCheckpoint($key, $checkpoint);
                }
            }

            $sentinel->setActivationRepository($app['sentinel.activations']);
            $sentinel->setReminderRepository($app['sentinel.reminders']);

            $sentinel->setRequestCredentials(function () use ($app) {
                $request = $app['request'];

                $login = $request->getUser();
                $password = $request->getPassword();

                if ($login === null && $password === null) {
                    return;
                }

                return compact('login', 'password');
            });

            $sentinel->creatingBasicResponse(function () {
                $headers = ['WWW-Authenticate' => 'Basic'];

                return new Response('Invalid credentials.', 401, $headers);
            });

            return $sentinel;
        });

        $this->app->alias('sentinel', GuardableSentinel::class);
        $this->app->alias(Sentinel::class, GuardableSentinel::class);
    }
}
