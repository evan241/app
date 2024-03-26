<?php

namespace App\NotificationStrategies;

use App\Models\User;
use App\NotificationStrategies\NotificationStrategy;

class SMSNotificationStrategy implements NotificationStrategy
{
    /**
     * Sends an SMS notification to the given user.
     *
     * @param string $message The message to send via SMS.
     * @param User $user The user to whom the SMS will be sent.
     * @return string "success" if the notification was sent successfully, "error message" otherwise.
     */
    public function sendNotification(string $message, User $user): string
    {
        // Check if the user has a phone number for SMS notifications
        if (empty($user->phone)) {
            // If the user does not have a phone number, log an error message and return false
            \Log::error("User {$user->id} does not have a phone number for SMS notifications.");
            return "User {$user->id} does not have a phone number for SMS notifications.";
        }

        // Implement the logic to send the SMS notification here
        // For example:
        $phoneNumber = $user->phone;
        // Code to send the SMS to the user's phone number with the provided message

        // Return "success" if the SMS notification was sent successfully
        return "success";
    }
}
