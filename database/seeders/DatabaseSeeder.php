<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        // Create admin user or get existing one
        $adminUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Assign admin role to the test user
        $adminRole = \App\Models\Role::where('name', 'admin')->first();
        if ($adminRole && ! $adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        // Create clients with related data
        \App\Models\Client::factory(10)->create([
            'owner_user_id' => $adminUser->id,
        ])->each(function ($client) {
            // Create client users
            \App\Models\ClientUser::factory(2)->create([
                'client_id' => $client->id,
                'user_id' => $client->owner_user_id,
            ]);

            // Create invoices
            \App\Models\Invoice::factory(5)->create([
                'client_id' => $client->id,
            ]);

            // Create products
            \App\Models\Product::factory(3)->create([
                'client_id' => $client->id,
            ]);

            // Create domains
            \App\Models\Domain::factory(2)->create([
                'client_id' => $client->id,
            ]);

            // Create quotes
            \App\Models\Quote::factory(2)->create([
                'client_id' => $client->id,
            ]);

            // Create tickets
            \App\Models\Ticket::factory(3)->create([
                'client_id' => $client->id,
            ]);

            // Create custom fields
            \App\Models\ClientCustomField::factory(1)->create([
                'client_id' => $client->id,
                'field_name' => 'Custom Field',
            ]);
        });
    }
}
