<?php

namespace Lotous\Elibom\Notifications;

use Illuminate\Support\Facades\Notification;
use Lotous\Elibom\Client as ElibomClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Notifications\NotificationServiceProvider as BaseNotificationServiceProvider;
use Illuminate\Contracts\Notifications\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Notifications\Factory as FactoryContract;

class ElibomChannelServiceProvider extends BaseNotificationServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->app->singleton(ChannelManager::class, function ($app) {
            $this->app['events']->fire('notification.beforeRegister', [$this]);

            return new ChannelManager($app);
        });

        $this->app->alias(
            ChannelManager::class, DispatcherContract::class
        );

        $this->app->alias(
            ChannelManager::class, FactoryContract::class
        );

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('elibom', function ($app) {
                return new Channels\ElibomSmsChannel(
                    $this->app->make(ElibomClient::class)
                );
            });
        });
    }
}
