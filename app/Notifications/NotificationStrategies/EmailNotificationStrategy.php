<?php

namespace App\Notifications\NotificationStrategies;

use App\Models\User;
use App\Notifications\NotificationStrategies\NotificationStrategy;
use Illuminate\Support\Facades\Log;

class EmailNotificationStrategy implements NotificationStrategy
{
    /**
     * Sends a notification via email to the given user.
     *
     * @param string $message The message to send via email.
     * @param User $user The user to whom the email will be sent.
     * @return string "success" if the notification was sent successfully, "error message" otherwise.
     */
    public function sendNotification(string $message, User $user): string
    {
        // Check if the user has a valid email address
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            // If the email address is not valid, return false and log an error message
            //\Log::error("User {$user->id} does not have a valid email address.");
            return "User {$user->id} does not have a valid email address.";
        }

        // Implement the logic to send the email notification here
        // For example:
        $email = $user->email;
        // Code to send the email to the user with the provided message

        // Return "success" if the notification was sent successfully
        return "success";
    }
}
