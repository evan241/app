<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\NotificationChannel;
use App\Models\MessageCategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'token_device' => Str::random(10),
        ];
    }

    public function withNotificationChannels(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $numberOfRelations = fake()->numberBetween(1, 3); // Genera un número aleatorio entre 1 y 3
            $channelIds = NotificationChannel::pluck('id')->shuffle()->take($numberOfRelations); // Obtén los IDs de canales de notificación aleatorios
            
            // Crear nuevos canales de notificación y relacionarlos con el usuario
            foreach ($channelIds as $channelId) {
                $user->notificationChannels()->create(['notification_channel_id' => $channelId]);
            }
        });
    }

    public function withMessageCategories(): UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $numberOfRelations = fake()->numberBetween(1, 3); // Genera un número aleatorio entre 1 y 3
            $categoryIds = MessageCategory::pluck('id')->shuffle()->take($numberOfRelations); // Obtén los IDs de canales de notificación aleatorios
            
            // Crear nuevas categorias de mensaje y relacionarlos con el usuario
            foreach ($categoryIds as $categoryId) {
                $user->subscribedCategories()->create(['message_category_id' => $categoryId]);
            }
        });
    }
}
