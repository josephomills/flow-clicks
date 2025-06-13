<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Link>
 */
class LinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'original_url' => fake()->url(),
            'short_url' => Str::random(6),
            'title' =>fake()->realTextBetween(10, 20),
            'description' => fake('en')->sentence(6),
            'is_custom'=>fake()->boolean(),
            'is_private'=>fake()->boolean(),
            'expires_at'=>fake()->dateTime(),
            'clicks'=>fake()->randomNumber()
        
        ];
    }
}
