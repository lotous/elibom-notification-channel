<?php
namespace Lotous\Elibom\Tests\Notifications\Channels;

use PHPUnit\Framework\TestCase;
use Lotous\Elibom\Notifications\Channels\ElibomSmsChannel;
use Lotous\Elibom\Notifications\Messages\ElibomMessage;
use Illuminate\Notifications\Notification;
use Lotous\Elibom\Client as ElibomClient;
use Mockery;

class ElibomSmsChannelTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    /** @test */
    public function it_sends_notification_via_elibom()
    {
        // Create a mock of ElibomClient
        $elibom = Mockery::mock(ElibomClient::class);

        // Set up the expected parameters for the sendMessage method
        $to = '123456789';
        $content = 'Test message content';

        // Expectation: sendMessage method should be called once with $to and $content
        $elibom->shouldReceive('sendMessage')
            ->once()
            ->with($to, $content)
            ->andReturn('Response from Elibom');

        // Create an instance of ElibomSmsChannel with the mock object
        $channel = new ElibomSmsChannel($elibom);

        // Create a mock of the notifiable object (you might need to adjust this depending on your application)
        $notifiable = Mockery::mock();
        $notifiable->shouldReceive('routeNotificationFor')
            ->once()
            ->with('elibom', Mockery::type(Notification::class))
            ->andReturn($to);

        // Create a mock of the notification object
        $notification = Mockery::mock(Notification::class);
        $notification->shouldReceive('toElibom')
            ->once()
            ->with($notifiable)
            ->andReturn(new ElibomMessage($content));

        // Call the send method on the channel
        $response = $channel->send($notifiable, $notification);

        // Assertion: Verify that the response from send method is correct
        $this->assertSame('Response from Elibom', $response);
    }
}