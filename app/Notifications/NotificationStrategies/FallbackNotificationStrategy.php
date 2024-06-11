<?php

namespace App\Notifications\NotificationStrategies;

use Illuminate\Support\Facades\Log;
use App\Models\User;

class FallbackNotificationStrategy implements NotificationStrategy
{
    public function sendNotification(string $message, User $user): string
    {
        \Log::info("Fallback notification sent to user {$user->id}: $message");
        return 'fallback_success';
    }
}