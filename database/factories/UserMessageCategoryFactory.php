<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserMessageCategory>
 */
class UserMessageCategoryFactory extends Factory
{
    protected $model = UserMessageCategory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'message_category_id' => MessageCategory::factory()->create()->id,
            'subscription_status' => fake()->boolean()
        ];
    }
}
