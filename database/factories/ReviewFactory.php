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
        $e_star = fake()->numberBetween(1, 5);
        $u_star = fake()->numberBetween(1, 5);
        $l_star = fake()->numberBetween(1, 5);
        $average_star = ($e_star + $u_star + $l_star) / 3;
        $rounded_average_star = round($average_star, 2); // Round to 2 decimal places


        return [
            'user_id' => User::pluck('id')->random(),
            'rental_id' => Rental::pluck('id')->random(),
            'environment_star' => $e_star,
            'unit_star' => $u_star,
            'landlord_star' => $l_star,
            'star' => $rounded_average_star,
            'message' => fake()->sentence(5),
        ];
    }
}
