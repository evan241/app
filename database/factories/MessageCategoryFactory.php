<?php

namespace Database\Factories;

use App\Models\MessageCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MessageCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence
        ];
    }
}
