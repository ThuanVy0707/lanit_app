<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domain>
 */
class DomainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $registrationDate = fake()->dateTimeBetween('-2 years', '-1 year');
        $expiryDate = (clone $registrationDate)->modify('+1 year');
        $registrationPrice = fake()->randomFloat(2, 8, 50);

        return [
            'domain_name' => fake()->unique()->domainName(),
            'status' => fake()->randomElement(['Active', 'Expired', 'Cancelled', 'Pending Transfer']),
            'registration_date' => $registrationDate,
            'expiry_date' => $expiryDate,
            'registration_price' => $registrationPrice,
            'renewal_price' => $registrationPrice * 1.1,
            'registrar' => fake()->randomElement(['GoDaddy', 'Namecheap', 'Google Domains', 'Cloudflare']),
        ];
    }
}
