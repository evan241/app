<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\Notification;
use App\Models\MessageCategory;
use App\Models\NotificationChannel;
use App\Models\User;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();

        return [
            'message' => $this->faker->sentence,
            'user_id' => $user->id,
            'user_name' => $this->faker->name,
            'user_email' => $this->faker->unique()->safeEmail,
            'user_phone' => $this->faker->phoneNumber,
            'token_device' => $this->faker->uuid,
            'message_category_id' => 1,
            'notification_channel_id' => 2,
            'send_status' => 'success',
            'created_at' => $this->faker->dateTimeBetween('-1 week', 'now'), // Fecha aleatoria en la última semana
        ];
    }
}
