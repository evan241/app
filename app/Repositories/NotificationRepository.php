<?php

namespace App\Repositories;

use App\Models\Notification;

class NotificationRepository
{
    public function getAllNotificationsWithRelations()
    {
        return Notification::with('messageCategory', 'notificationChannel')
            ->latest()
            ->get();
    }

    /**
     * Searches for notifications by date within a specific range.
     *
     * @param string $startDate The start date of the search range.
     * @param string $endDate The end date of the search range.
     * @return \Illuminate\Database\Eloquent\Collection Collection of notifications found within the date range.
     */
    public function searchByDate(string $startDate, string $endDate)
    {
        return Notification::whereBetween('created_at', [$startDate, $endDate])->get();
    }
}
