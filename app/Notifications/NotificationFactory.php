<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Log;
use App\Notifications\NotificationStrategies\NotificationStrategy;
use App\Notifications\NotificationStrategies\EmailNotificationStrategy;
use App\Notifications\NotificationStrategies\SMSNotificationStrategy;
use App\Notifications\NotificationStrategies\PushNotificationStrategy;
use App\Notifications\NotificationStrategies\FallBackNotificationStrategy;

class NotificationFactory
{
    /**
     * Instantiates the appropriate notification strategy based on the specified type.
     *
     * @param string $channelName The channel of notification strategy (for example, 'email', 'sms', 'push').
     * @return NotificationStrategy An instance of the corresponding notification strategy.
     */
    public static function createNotificationStrategy(string $channelName): NotificationStrategy
    {
        switch ($channelName) {
            case 'mail':
                return new EmailNotificationStrategy();
            case 'sms':
                return new SMSNotificationStrategy();
            case 'push':
                return new PushNotificationStrategy();
            default:
                return new FallbackNotificationStrategy();
                //\Log::warning("Unknown notification strategy type: $channelName");
        }
    }
}
