<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Deal;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deal>
 */
class DealFactory extends Factory
{
    protected $model = Deal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'flight',
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'price' => $this->faker->randomFloat(2, 50, 1000),
            'departure_date' => $this->faker->dateTimeBetween('now', '+1 month'),
            'return_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'details' => json_encode(['carrier' => $this->faker->company]),
        ];
    }
}
