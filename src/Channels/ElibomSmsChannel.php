<?php

namespace Illuminate\Notifications\Channels;

use Lotous\Elibom\Notifications\Messages\ElibomMessage;
use Illuminate\Notifications\Notification;
use Lotous\Elibom\Client as ElibomClient;

class ElibomSmsChannel
{
    /**
     * The Elibom client instance.
     *
     * @var Lotous\Elibom\Client
     */
    protected $elibom;


    /**
     * Create a new Elibom channel instance.
     *
     * @param  Lotous\Elibom\Client  $elibom
     * @return void
     */
    public function __construct(ElibomClient $elibom)
    {
        $this->elibom = $elibom;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return Lotous\Elibom\Message\Message
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('elibom', $notification)) {
            return;
        }

        $message = $notification->toElibom($notifiable);

        if (is_string($message)) {
            $message = new ElibomMessage($message);
        }

        return ($message->client ?? $this->elibom)->sendMessage(
            $to,
            trim($message->content)
        );
    }
}
