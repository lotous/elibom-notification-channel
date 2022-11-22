<?php

namespace Lotous\Elibom\Notifications;

use Illuminate\Support\Facades\Notification;
use Lotous\Elibom\Client;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Notifications\NotificationServiceProvider as BaseNotificationServiceProvider;
use Lotous\Elibom\Notifications\Channels\ElibomSmsChannel;

class ElibomChannelServiceProvider extends BaseNotificationServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ElibomSmsChannel::class, function ($app) {
            return new ElibomSmsChannel(
                $app->make(Client::class),
            );
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('elibom', function ($app) {
                return new Channels\ElibomSmsChannel(
                    $this->app->make(Client::class)
                );
            });
        });
    }
}
