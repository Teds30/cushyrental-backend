<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Subscription;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitSubscription>
 */
class UnitSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Unit::pluck('id')->random(),
            'subscription_id' => Subscription::pluck('id')->random(),
            'pop_image_id' => Image::pluck('id')->random(),
            'account_number' => '0912-345-6789',
            'account_name' => fake()->firstName(),
            'email_address' => fake()->unique()->safeEmail(),
            'date_start' => now(),
            'date_end' => now(),
        ];
    }
}
