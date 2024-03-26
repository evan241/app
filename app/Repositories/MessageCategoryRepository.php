<?php

namespace App\Repositories;

use App\Models\MessageCategory;

class MessageCategoryRepository
{
    public function getCategoryNameById($categoryId)
    {
        return MessageCategory::findOrFail($categoryId)->name;
    }

    public function getAllCategories()
    {
        return MessageCategory::all();
    }
}
