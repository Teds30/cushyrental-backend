<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnitImage>
 */
class UnitImageFactory extends Factory
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
            'image_id' => Image::pluck('id')->random(),
        ];
    }
}
