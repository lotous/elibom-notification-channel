<?php

namespace Lotous\Elibom\Notifications\Tests\App\Notifications;

use Illuminate\Notifications\Notification as BaseNotification;
use Lotous\Elibom\Notifications\Messages\ElibomMessage;

class TestNotification extends BaseNotification
{

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['elibom'];
    }


    public function toElibom($notifiable)
    {
        return (new ElibomMessage)->content( 'Test SMS Content');
    }

}