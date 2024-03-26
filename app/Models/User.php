<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'token_device'
    ];

    /**
     * Get the user's subscribed categories.
     */
    public function subscribedCategories()
    {
        return $this->hasMany(UserMessageCategory::class);
    }

    /**
     * Get the user's notification channels.
     */
    public function notificationChannels()
    {
        return $this->hasMany(UserNotificationChannel::class);
    }

    /**
     * Get the user's notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
