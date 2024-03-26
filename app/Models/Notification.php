<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'user_id',
        'user_name',
        'user_email',
        'user_phone',
        'token_device',
        'message_category_id',
        'notification_channel_id'
    ];

    public function notificationChannel()
    {
        return $this->belongsTo(NotificationChannel::class, 'notification_channel_id');
    }

    public function messageCategory()
    {
        return $this->belongsTo(MessageCategory::class, 'message_category_id');
    }
}
