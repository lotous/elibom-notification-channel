<?php

namespace Lotous\Elibom\Notifications;

use Illuminate\Support\Facades\Notification;
use Lotous\Elibom\Client as ElibomClient;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Notifications\NotificationServiceProvider as BaseNotificationServiceProvider;

class ElibomChannelServiceProvider extends BaseNotificationServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('elibom', function ($app) {
                return new Channels\ElibomSmsChannel(
                    $this->app->make(ElibomClient::class)
                );
            });
        });
    }
}
