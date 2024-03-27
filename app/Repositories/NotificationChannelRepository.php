<?php

namespace App\Repositories;

use App\Models\NotificationChannel;

class NotificationChannelRepository
{
    public function getChannelNameById($channelId)
    {
        return NotificationChannel::findOrFail($channelId)->name;
    }

    public function getAllChannels()
    {
        return NotificationChannel::all();
    }
}
