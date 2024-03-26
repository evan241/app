<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getUsersSubscribedToCategory($categoryId)
    {
        return User::with('notificationChannels.channel')
            ->whereHas('subscribedCategories', function ($query) use ($categoryId) {
                $query->where('message_category_id', $categoryId);
            })
            ->get();
    }
}