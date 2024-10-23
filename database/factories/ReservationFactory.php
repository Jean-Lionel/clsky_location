<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\User;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'user_id' => User::factory(),
            'check_in' => $this->faker->date(),
            'check_out' => $this->faker->date(),
            'total_price' => $this->faker->randomFloat(2, 0, 99999999.99),
            'guests' => $this->faker->numberBetween(-10000, 10000),
            'status' => $this->faker->randomElement(["pending","confirmed","cancelled","completed"]),
            'payment_status' => $this->faker->randomElement(["pending","paid","refunded"]),
            'notes' => $this->faker->text(),
        ];
    }
}
