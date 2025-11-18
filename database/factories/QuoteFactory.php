<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-6 months', 'now');
        $validUntil = (clone $date)->modify('+'.fake()->numberBetween(7, 30).' days');
        $subtotal = fake()->randomFloat(2, 50, 1000);
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return [
            'quote_number' => 'QUO-'.fake()->unique()->numerify('######'),
            'subject' => fake()->sentence(),
            'date' => $date,
            'valid_until' => $validUntil,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'status' => fake()->randomElement(['Draft', 'Sent', 'Accepted', 'Declined', 'Expired']),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
