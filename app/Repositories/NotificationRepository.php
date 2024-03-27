<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{
    public function getSearchNotificationsWithRelations($field, $searchFor, $startDate, $endDate, $categoryId, $channelId)
    {
        return Notification::with('messageCategory', 'notificationChannel')
            ->searchFor($field, $searchFor, $startDate, $endDate, $categoryId, $channelId)
            ->latest()
            ->paginate(10);
    }
}
