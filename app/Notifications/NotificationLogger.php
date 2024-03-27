<?php

namespace App\Notifications;

use App\Notifications\NotificationStrategies\NotificationStrategy;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class NotificationLogger
{
    /**
     *Record the notification in the log.
     *
     * @param User $user The user to whom the notification was sent.
     * @param string $message The message sent.
     * @param string $categoryId The category id of the message.
     * @param string $channelId The notification channel id.
     * @param string $channelName The notification channel name.
     * @param string $status The status of sending the notification.
     * @return void
     */
    public static function logNotification(User $user, string $message, int $categoryId, string $categoryName, int $channelId, string $channelName, string $status)
    {
        // Record the notification in the log
        $logData = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'token_device' => $user->token_device,
            'message_category_id' => $categoryId,
            'message_category_name' => $categoryName,
            'notification_channel_id' => $channelId,
            'notification_channel' => $channelName,
            'message' => $message,
            'datetime' => now()->toDateTimeString(),
            'send_status' => $status,
        ];

        // Writing to log file:
        Log::info('Notification sent: ' . json_encode($logData));

        // Create an instance of the notification record model and assign the values
        $notificationLog = new Notification();
        $notificationLog->user_id = $user->id;
        $notificationLog->user_name = $user->name;
        $notificationLog->user_email = $user->email;
        $notificationLog->user_phone = $user->phone;
        $notificationLog->token_device = $user->token_device;
        $notificationLog->message_category_id = $categoryId;
        $notificationLog->notification_channel_id = $channelId;
        $notificationLog->message = $message;
        $notificationLog->send_status = $status;

        // Save the record to the database
        $notificationLog->save();
    }
}
