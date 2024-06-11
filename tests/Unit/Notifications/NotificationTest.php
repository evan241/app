<?php

namespace Tests\Unit\Notifications;

use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Notification;
use App\Notifications\NotificationContext;
use App\Notifications\NotificationFactory;
use App\Notifications\NotificationLogger;
use App\Notifications\NotificationStrategies\NotificationStrategy;
use App\Notifications\NotificationStrategies\EmailNotificationStrategy;
use App\Notifications\NotificationStrategies\PushNotificationStrategy;
use App\Notifications\NotificationStrategies\SMSNotificationStrategy;
use App\Notifications\NotificationStrategies\FallbackNotificationStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;
    private $user;

   /** @test */
    public function it_can_create_email_notification_strategy()
    {
        $strategy = NotificationFactory::createNotificationStrategy('mail');
        
        $this->assertInstanceOf(EmailNotificationStrategy::class, $strategy);
    }

    /** @test */
    public function it_can_create_sms_notification_strategy()
    {
        $strategy = NotificationFactory::createNotificationStrategy('sms');
        
        $this->assertInstanceOf(SMSNotificationStrategy::class, $strategy);
    }

    /** @test */
    public function it_can_create_push_notification_strategy()
    {
        $strategy = NotificationFactory::createNotificationStrategy('push');
        
        $this->assertInstanceOf(PushNotificationStrategy::class, $strategy);
    }

    /** @test */
    public function it_returns_fallback_strategy_for_unknown_notification_strategy()
    {
        $strategy = NotificationFactory::createNotificationStrategy('unknown');

        $this->assertInstanceOf(FallbackNotificationStrategy::class, $strategy);
    }

    /** @test */
    public function it_can_send_notification_via_email()
    {
        $strategy = new EmailNotificationStrategy();

        $user = new User();
        $user->email = 'test@example.com';

        $message = 'Test message';

        $result = $strategy->sendNotification($message, $user);

        $this->assertEquals('success', $result);
    }

    /** @test */
    public function it_handles_invalid_email_address()
    {
        $strategy = new EmailNotificationStrategy();

        $user = new User();
        $user->email = 'invalid-email'; // Invalid email address

        $message = 'Test message';

        $result = $strategy->sendNotification($message, $user);

        $this->assertEquals("User {$user->id} does not have a valid email address.", $result);
    }

    /** @test */
    public function it_can_send_push_notification_successfully()
    {
        // Mocking a user with a device token
        $user = new User();
        $user->id = 1;
        $user->token_device = 'device_token';

        // Mocking the Log facade to prevent actual logging during the test
        Log::shouldReceive('error')->never();

        // Creating an instance of PushNotificationStrategy
        $strategy = new PushNotificationStrategy();

        // Testing the sendNotification method
        $result = $strategy->sendNotification('Test message', $user);

        // Asserting that the result is 'success'
        $this->assertEquals('success', $result);
    }

    /** @test */
    public function it_returns_error_if_user_has_no_device_token()
    {
        // Mocking a user without a device token
        $user = new User();
        $user->id = 1;
        $user->token_device = null;

        // Mocking the Log facade to check if the error is logged
        Log::shouldReceive('error')->once();

        // Creating an instance of PushNotificationStrategy
        $strategy = new PushNotificationStrategy();

        // Testing the sendNotification method
        $result = $strategy->sendNotification('Test message', $user);

        // Asserting that the result contains an error message
        $this->assertStringContainsString('does not have a device token', $result);
    }

    /** @test */
    public function it_can_send_sms_notification_successfully()
    {
        // Mocking a user with a phone number
        $user = new User();
        $user->id = 1;
        $user->phone = '123456789'; // Assuming this is a valid phone number

        // Mocking the Log facade to prevent actual logging during the test
        Log::shouldReceive('error')->never();

        // Creating an instance of SMSNotificationStrategy
        $strategy = new SMSNotificationStrategy();

        // Testing the sendNotification method
        $result = $strategy->sendNotification('Test message', $user);

        // Asserting that the result is 'success'
        $this->assertEquals('success', $result);
    }

    /** @test */
    public function it_returns_error_if_user_has_no_phone_number()
    {
        // Mocking a user without a phone number
        $user = new User();
        $user->id = 1;
        $user->phone = null;

        // Mocking the Log facade to check if the error is logged
        Log::shouldReceive('error')->once();

        // Creating an instance of SMSNotificationStrategy
        $strategy = new SMSNotificationStrategy();

        // Testing the sendNotification method
        $result = $strategy->sendNotification('Test message', $user);

        // Asserting that the result contains an error message
        $this->assertStringContainsString('does not have a phone number', $result);
    }

    /** @test */
    /*public function it_logs_notification_and_saves_to_database(): void
    {
        // Create a mock user
        $user = new User([
            'id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'token_device' => 'device_token',
        ]);

        // Set up expectations for the Log facade
        Log::shouldReceive('info')->once()->with(
            'Notification sent: ' . json_encode([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_phone' => $user->phone,
                'token_device' => $user->token_device,
                'message_category_id' => 1,
                'message_category_name' => 'Test Category',
                'notification_channel_id' => 1,
                'notification_channel' => 'Test Channel',
                'message' => 'Test notification message',
                'datetime' => now()->toDateTimeString(),
                'send_status' => 'success',
            ])
        );

        // Call the logNotification method to log the notification
        NotificationLogger::logNotification(
            $user,
            'Test notification message',
            1,
            'Test Category',
            1,
            'Test Channel',
            'success'
        );

        // Verify that the notification record has been saved to the database
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'token_device' => $user->token_device,
            'message_category_id' => 1,
            'notification_channel_id' => 1,
            'message' => 'Test notification message',
            'send_status' => 'success',
        ]);
    }*/
}
