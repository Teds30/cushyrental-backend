<?php

namespace Database\Factories;

use App\Models\Rule;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitRule>
 */
class UnitRuleFactory extends Factory
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
            'rule_id' => Rule::pluck('id')->random(),
        ];
    }
}
