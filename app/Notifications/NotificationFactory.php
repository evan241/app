<?php

namespace App\Notifications;

use App\NotificationStrategies\NotificationStrategy;
use App\NotificationStrategies\EmailNotificationStrategy;
use App\NotificationStrategies\SMSNotificationStrategy;
use App\NotificationStrategies\PushNotificationStrategy;

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
                \Log::warning("Unknown notification strategy type: $channelName");
                //throw new \InvalidArgumentException("Unknown notification strategy type: $channelName");
        }
    }
}
