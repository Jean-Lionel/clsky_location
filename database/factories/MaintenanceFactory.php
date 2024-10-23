<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Maintenance;
use App\Models\Property;
use App\Models\User;

class MaintenanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Maintenance::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'reported_by' => User::factory()->create()->reported_by,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->text(),
            'priority' => $this->faker->randomElement(["low","medium","high","urgent"]),
            'status' => $this->faker->randomElement(["pending","in_progress","completed","cancelled"]),
            'completed_at' => $this->faker->dateTime(),
        ];
    }
}
