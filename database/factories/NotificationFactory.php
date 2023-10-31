<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => 'Rental Payment Reminder',
            'message' => fake()->sentence(10),
            'redirect_url' => '/',
            'user_id' => 1,
            'is_read' => 0,
        ];
    }
}
