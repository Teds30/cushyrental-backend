<?php

namespace Database\Factories;

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
            'date_start' => now(),
            'date_end' => now(),
        ];
    }
}
