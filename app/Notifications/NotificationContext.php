<?php

namespace App\Notifications;

use App\Notifications\NotificationStrategies\NotificationStrategy;
use App\Notifications\NotificationLogger;
use App\Models\User;
use Exception;

class NotificationContext
{
    protected $strategy;

    public function __construct(NotificationStrategy $strategy)
    {
        $this->setStrategy($strategy);
    }

    /**
     * Establish the strategy to use.
     *
     * @param NotificationStrategy $strategy The strategy to use.
     */
    public function setStrategy(NotificationStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Send a notification to the given user using the current strategy.
     *
     * @param string $message The message to send.
     * @param User $user The user to whom the notification will be sent.
     * @param int $categoryId The id of the message category.
     * @param string $categoryName The name of the message category
     * @param int $channelId The notification channel id of the message
     * @param string $channelName The notification channel name of the message
     * @param string $status The status of sending the notification.
     * @return bool True if the notification was sent successfully, false otherwise.
     */
    public function sendNotification(string $message, User $user, int $categoryId, string $categoryName, int $channelId, string $channelName): bool
    {
        // Delegate the task of sending the notification to the current strategy
        $status = $this->strategy->sendNotification($message, $user);

        // After sending the notification, we record the action in the log
        NotificationLogger::logNotification($user, $message, $categoryId, $categoryName, $channelId, $channelName, $status);

        return true;
    }
}
