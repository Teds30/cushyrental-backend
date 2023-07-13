<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitFacility>
 */
class UnitFacilityFactory extends Factory
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
            'facility_id' => Facility::pluck('id')->random(),
            'is_shared' => 0,
        ];
    }
}
