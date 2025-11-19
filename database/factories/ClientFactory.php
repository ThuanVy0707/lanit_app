<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'companyname' => fake()->optional()->company(),
            'email' => fake()->unique()->safeEmail(),
            'address1' => fake()->streetAddress(),
            'address2' => fake()->optional()->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postcode' => fake()->postcode(),
            'countrycode' => fake()->countryCode(),
            'phonenumber' => fake()->phoneNumber(),
            'tax_id' => fake()->optional()->numerify('TAX-#####'),
            'email_preferences' => [
                'general' => '1',
                'invoice' => '1',
                'support' => '1',
                'product' => '1',
                'domain' => '1',
                'affiliate' => '1',
            ],
            'currency_id' => 1,
            'defaultgateway' => fake()->randomElement(['stripe', 'paypal', '']),
            'groupid' => 0,
            'status' => fake()->randomElement(['Active', 'Inactive']),
            'source' => fake()->randomElement(['Website', 'Referral', 'Social Media', 'Advertisement', 'Partner', 'Direct', 'Other', null]),
            'credit' => fake()->randomFloat(2, 0, 1000),
            'taxexempt' => fake()->boolean(20),
            'latefeeoveride' => fake()->boolean(10),
            'overideduenotices' => fake()->boolean(10),
            'separateinvoices' => fake()->boolean(20),
            'disableautocc' => fake()->boolean(10),
            'emailoptout' => fake()->boolean(5),
            'marketing_emails_opt_in' => fake()->boolean(80),
            'overrideautoclose' => fake()->boolean(10),
            'allowSingleSignOn' => fake()->boolean(90),
            'email_verified' => fake()->boolean(90),
            'language' => fake()->randomElement(['', 'en', 'vi']),
            'lastlogin' => fake()->optional(0.7)->dateTime()?->format('d/m/Y H:i'),
            'notes' => fake()->optional()->paragraph(),
        ];
    }
}
