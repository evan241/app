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

    public function scopeSearchFor($query, $field, $searchFor, $startDate, $endDate, $categoryId, $channelId)
    {
        if ($field === 'created_at' && $startDate && $endDate) {
            $startDateTime = $startDate . ' 00:00:00';
            $endDateTime = $endDate . ' 23:59:59';
            return $query->whereBetween($field, [$startDateTime, $endDateTime]);
        } elseif ($field === 'message_category_id' && $categoryId) {
            return $query->where($field, $categoryId);
        } elseif ($field === 'notification_channel_id' && $channelId) {
            return $query->where($field, $channelId);
        } else if ( $field && $searchFor ) {
            return $query->where($field,'like',"%$searchFor%");
        }
    }

    public function notificationChannel()
    {
        return $this->belongsTo(NotificationChannel::class, 'notification_channel_id');
    }

    public function messageCategory()
    {
        return $this->belongsTo(MessageCategory::class, 'message_category_id');
    }
}
