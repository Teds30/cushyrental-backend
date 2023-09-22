<?php

namespace Database\Factories;

use App\Models\Rental;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::pluck('id')->random(),
            'rental_id' => Rental::pluck('id')->random(),
            'star' => fake()->numberBetween(1, 5),
            'message' => fake()->sentence(5),
        ];
    }
}
