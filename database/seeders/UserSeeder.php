<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\NotificationChannel;
use App\Models\MessageCategory;

use Database\Factories\UserFactory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Use the factory to create user instances with test data
       UserFactory::new()
            ->withNotificationChannels()
            ->withMessageCategories()
            ->count(10)
            ->create();
    }
}
