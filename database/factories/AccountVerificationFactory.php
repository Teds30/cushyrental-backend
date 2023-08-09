<?php

namespace Database\Factories;

use App\Models\IdentificationCardType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountVerification>
 */
class AccountVerificationFactory extends Factory
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
            'checked_by_id' => User::pluck('id')->random(),
            'identification_card_type_id' => IdentificationCardType::pluck('id')->random(),
            'verdict' => fake()->numberBetween(0, 2),
            'submitted_id_image_url' => 'submitted_id/1.png',
            'address' => 'Legazpi City, Albay',
            'contact_number' => fake()->phoneNumber(),
            'denied_reason' => fake()->sentence(5),
        ];
    }
}
