<?php

namespace Lotous\Elibom\Notifications\Tests\Feature;


use Illuminate\Support\Facades\Notification;
use Lotous\Elibom\Notifications\Tests\App\Notifications\TestNotification;
use Lotous\Elibom\Notifications\Tests\App\TestNotifiable;
use Lotous\Elibom\Notifications\Tests\TestCase;


class ElibomSmsChannelTest extends TestCase
{

    /**
     * @return void
     */
    public function testCanSendSmsViaElibom()
    {
        $user = new TestNotifiable();

        Notification::fake(); // Indicamos a Laravel que falsifique las notificaciones

        $user->notify(new TestNotification()); // Notificar al usuario

        // Assert
        Notification::assertSentTo(
            $user,
            TestNotification::class,
            function ($notification, $channels) {

                // Verifica si la notificación se envía a través del canal 'mail'
                return in_array('elibom', $channels);
            }
        );
    }
}