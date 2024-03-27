<?php

namespace App\Notifications\NotificationStrategies;

use App\Models\User;

interface NotificationStrategy
{
    /**
     * Send a notification to the given user.
     *
     * @param string $message The message to send.
     * @param User $user The user to whom the notification will be sent.
     * @return string "success" if the notification was sent successfully, "error message" otherwise.
     */
    public function sendNotification(string $message, User $user): string;
}
