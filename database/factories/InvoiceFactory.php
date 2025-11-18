<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 year', 'now');
        $duedate = (clone $date)->modify('+'.fake()->numberBetween(7, 30).' days');
        $subtotal = fake()->randomFloat(2, 10, 500);
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax;

        return [
            'invoice_number' => 'INV-'.fake()->unique()->numerify('######'),
            'date' => $date,
            'duedate' => $duedate,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'credit' => 0,
            'status' => fake()->randomElement(['Paid', 'Unpaid', 'Cancelled']),
            'payment_method' => fake()->randomElement(['stripe', 'paypal', 'bank_transfer', null]),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
