<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Message;
use App\Models\Property;
use App\Models\User;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sender_id' => User::factory(),
            'receiver_id' => User::factory(),
            'property_id' => Property::factory(),
            'subject' => $this->faker->word(),
            'content' => $this->faker->paragraphs(3, true),
            'read_at' => $this->faker->dateTime(),
        ];
    }
}
