<?php

namespace App\Notifications\NotificationStrategies;

use App\Models\User;
use App\Notifications\NotificationStrategies\NotificationStrategy;
use Illuminate\Support\Facades\Log;

class PushNotificationStrategy implements NotificationStrategy
{
    /**
     * Sends a push notification to the given user.
     *
     * @param string $message The message to send as a push notification.
     * @param User $user The user to whom the push notification will be sent.
     * @return string "success" if the notification was sent successfully, "error message" otherwise.
     */
    public function sendNotification(string $message, User $user): string
    {
        // Check if the user has a device token for push notifications
        if (empty($user->token_device)) {
            // If the user does not have a device token, log an error message and return false
            //\Log::error("User {$user->id} does not have a device token for push notifications.");
            return "User {$user->id} does not have a device token for push notifications.";
        }

        // Implement the logic to send the push notification here
        // For example:
        $tokenDevice = $user->token_device;
        // Code to send the push notification to the user's device with the provided message

        // Return "success" if the push notification was sent successfully
        return "success";
    }
}
