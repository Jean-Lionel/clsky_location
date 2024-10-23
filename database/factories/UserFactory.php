<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'email_verified_at' => $this->faker->dateTime(),
            'password' => $this->faker->password(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->text(),
            'role' => $this->faker->randomElement(["admin","owner","tenant","agent"]),
            'avatar' => $this->faker->word(),
            'status' => $this->faker->randomElement(["active","inactive"]),
            'remember_token' => $this->faker->uuid(),
        ];
    }
}
