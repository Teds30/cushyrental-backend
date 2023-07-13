<?php

namespace Database\Factories;

use App\Models\Amenity;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitAmenity>
 */
class UnitAmenityFactory extends Factory
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
            'amenity_id' => Amenity::pluck('id')->random(),
        ];
    }
}
