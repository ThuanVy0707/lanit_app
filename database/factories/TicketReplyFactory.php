<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketReply>
 */
class TicketReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $isStaffReply = fake()->boolean(60);

        return [
            'message' => fake()->paragraph(3),
            'is_staff_reply' => $isStaffReply,
            'user_id' => $isStaffReply ? 1 : null,
            'client_id' => $isStaffReply ? null : null,
        ];
    }
}
