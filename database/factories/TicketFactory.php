<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_number' => 'TKT-'.fake()->unique()->numerify('######'),
            'subject' => fake()->sentence(),
            'department' => fake()->randomElement(['Support', 'Sales', 'Billing', 'Technical']),
            'priority' => fake()->randomElement(['Low', 'Medium', 'High', 'Critical']),
            'status' => fake()->randomElement(['Open', 'Pending', 'Answered', 'Closed']),
            'message' => fake()->paragraph(),
        ];
    }
}
