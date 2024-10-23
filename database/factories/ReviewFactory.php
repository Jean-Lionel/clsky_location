<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory(),
            'reservation_id' => Reservation::factory(),
            'rating' => $this->faker->numberBetween(-10000, 10000),
            'comment' => $this->faker->text(),
            'status' => $this->faker->randomElement(["pending","approved","rejected"]),
        ];
    }
}
