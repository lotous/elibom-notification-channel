<?php

namespace Lotous\Elibom\Notifications;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Lotous\Elibom\Client as ElibomClient;

class ElibomChannelServiceProvider extends ServiceProvider
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
                    $this->app->make(ElibomClient::class),
                    $this->app['config']['services.elibom.sms_from']
                );
            });
        });
    }
}
