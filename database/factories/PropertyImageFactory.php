<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PropertyImage::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'image_path' => $this->faker->word(),
            'is_primary' => $this->faker->boolean(),
            'sort_order' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
