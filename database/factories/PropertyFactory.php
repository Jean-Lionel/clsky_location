<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\User;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->text(),
            'address' => $this->faker->text(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->postcode(),
            'price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'bedrooms' => $this->faker->numberBetween(-10000, 10000),
            'bathrooms' => $this->faker->numberBetween(-10000, 10000),
            'area' => $this->faker->randomFloat(2, 0, 999999.99),
            'floor' => $this->faker->numberBetween(-10000, 10000),
            'furnished' => $this->faker->boolean(),
            'available' => $this->faker->boolean(),
            'type' => $this->faker->randomElement(["apartment","studio","duplex"]),
            'status' => $this->faker->randomElement(["available","rented","maintenance"]),
            'featured' => $this->faker->boolean(),
            'user_id' => User::factory(),
        ];
    }
}
