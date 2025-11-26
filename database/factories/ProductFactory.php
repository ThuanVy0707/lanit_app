<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['hosting', 'reseller', 'server', 'other']);

        return [
            'name' => fake()->words(3, true).' '.ucfirst($type),
            'type' => $type,
            'status' => fake()->randomElement(['Active', 'Suspended', 'Terminated', 'Cancelled']),
            'amount' => fake()->randomFloat(2, 5, 200),
            'billing_cycle' => fake()->randomElement(['monthly', 'quarterly', 'semi-annually', 'annually']),
            'next_due_date' => fake()->dateTimeBetween('now', '+1 year'),
            'description' => fake()->optional()->paragraph(),
        ];
    }
}
