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
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * Create a new Elibom channel instance.
     *
     * @param  Lotous\Elibom\Client  $elibom
     * @param  string  $from
     * @return void
     */
    public function __construct(ElibomClient $elibom, $from)
    {
        $this->from = $from;
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
