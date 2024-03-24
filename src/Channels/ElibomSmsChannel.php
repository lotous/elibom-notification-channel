<?php

namespace Lotous\Elibom\Notifications\Channels;

use Lotous\Elibom\Notifications\Messages\ElibomMessage;
use Illuminate\Notifications\Notification;
use Lotous\Elibom\Client as ElibomClient;

class ElibomSmsChannel
{
    /**
     * @var ElibomClient
     */
    protected $elibom;


    /**
     * @param ElibomClient $elibom
     */
    public function __construct(ElibomClient $elibom)
    {
        $this->elibom = $elibom;
    }

    /**
     * @param $notifiable
     * @param Notification $notification
     * @return \Psr\Http\Message\ResponseInterface|void
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
