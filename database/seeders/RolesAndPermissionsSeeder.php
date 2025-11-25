<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Users
            ['name' => 'users.index', 'description' => 'View users'],
            ['name' => 'users.create', 'description' => 'Create users'],
            ['name' => 'users.store', 'description' => 'Store users'],
            ['name' => 'users.show', 'description' => 'Show users'],
            ['name' => 'users.edit', 'description' => 'Edit users'],
            ['name' => 'users.update', 'description' => 'Update users'],
            ['name' => 'users.destroy', 'description' => 'Delete users'],

            // Clients
            ['name' => 'clients.index', 'description' => 'View clients'],
            ['name' => 'clients.create', 'description' => 'Create clients'],
            ['name' => 'clients.store', 'description' => 'Store clients'],
            ['name' => 'clients.show', 'description' => 'Show clients'],
            ['name' => 'clients.edit', 'description' => 'Edit clients'],
            ['name' => 'clients.update', 'description' => 'Update clients'],
            ['name' => 'clients.destroy', 'description' => 'Delete clients'],

            // Invoices
            ['name' => 'invoices.index', 'description' => 'View invoices'],
            ['name' => 'invoices.create', 'description' => 'Create invoices'],
            ['name' => 'invoices.store', 'description' => 'Store invoices'],
            ['name' => 'invoices.show', 'description' => 'Show invoices'],
            ['name' => 'invoices.edit', 'description' => 'Edit invoices'],
            ['name' => 'invoices.update', 'description' => 'Update invoices'],
            ['name' => 'invoices.destroy', 'description' => 'Delete invoices'],

            // Tickets
            ['name' => 'tickets.index', 'description' => 'View tickets'],
            ['name' => 'tickets.create', 'description' => 'Create tickets'],
            ['name' => 'tickets.store', 'description' => 'Store tickets'],
            ['name' => 'tickets.show', 'description' => 'Show tickets'],
            ['name' => 'tickets.edit', 'description' => 'Edit tickets'],
            ['name' => 'tickets.update', 'description' => 'Update tickets'],
            ['name' => 'tickets.destroy', 'description' => 'Delete tickets'],
            ['name' => 'tickets.reply', 'description' => 'Reply to tickets'],
            ['name' => 'tickets.merge', 'description' => 'Merge tickets'],

            // Products
            ['name' => 'products.index', 'description' => 'View products'],
            ['name' => 'products.create', 'description' => 'Create products'],
            ['name' => 'products.store', 'description' => 'Store products'],
            ['name' => 'products.show', 'description' => 'Show products'],
            ['name' => 'products.edit', 'description' => 'Edit products'],
            ['name' => 'products.update', 'description' => 'Update products'],
            ['name' => 'products.destroy', 'description' => 'Delete products'],

            // Orders
            ['name' => 'orders.index', 'description' => 'View orders'],
            ['name' => 'orders.create', 'description' => 'Create orders'],
            ['name' => 'orders.store', 'description' => 'Store orders'],
            ['name' => 'orders.show', 'description' => 'Show orders'],
            ['name' => 'orders.edit', 'description' => 'Edit orders'],
            ['name' => 'orders.update', 'description' => 'Update orders'],
            ['name' => 'orders.destroy', 'description' => 'Delete orders'],

            // Reports
            ['name' => 'reports.index', 'description' => 'View reports'],

            // Dashboard
            ['name' => 'dashboard', 'description' => 'View dashboard'],

            // Profile
            ['name' => 'profile.edit', 'description' => 'Edit profile'],
            ['name' => 'profile.update', 'description' => 'Update profile'],
            ['name' => 'profile.destroy', 'description' => 'Delete profile'],

            // Roles
            ['name' => 'roles.index', 'description' => 'View roles'],
            ['name' => 'roles.create', 'description' => 'Create roles'],
            ['name' => 'roles.store', 'description' => 'Store roles'],
            ['name' => 'roles.show', 'description' => 'Show roles'],
            ['name' => 'roles.edit', 'description' => 'Edit roles'],
            ['name' => 'roles.update', 'description' => 'Update roles'],
            ['name' => 'roles.destroy', 'description' => 'Delete roles'],
        ];

        foreach ($permissions as $permission) {
            \App\Models\Permission::firstOrCreate($permission);
        }

        // Create roles
        $adminRole = \App\Models\Role::firstOrCreate([
            'name' => 'admin',
            'description' => 'Administrator with full access',
        ]);

        $managerRole = \App\Models\Role::firstOrCreate([
            'name' => 'manager',
            'description' => 'Manager with limited administrative access',
        ]);

        $userRole = \App\Models\Role::firstOrCreate([
            'name' => 'user',
            'description' => 'Regular user with basic access',
        ]);

        // Assign permissions to roles
        $adminRole->permissions()->sync(\App\Models\Permission::all());

        $managerRole->permissions()->sync(
            \App\Models\Permission::whereIn('name', [
                'users.index', 'users.create', 'users.store', 'users.show', 'users.edit', 'users.update',
                'clients.index', 'clients.create', 'clients.store', 'clients.show', 'clients.edit', 'clients.update',
                'invoices.index', 'invoices.create', 'invoices.store', 'invoices.show', 'invoices.edit', 'invoices.update',
                'tickets.index', 'tickets.create', 'tickets.store', 'tickets.show', 'tickets.edit', 'tickets.update', 'tickets.reply', 'tickets.merge',
                'products.index', 'products.create', 'products.store', 'products.show', 'products.edit', 'products.update',
                'orders.index', 'orders.create', 'orders.store', 'orders.show', 'orders.edit', 'orders.update',
                'reports.index',
            ])->get()
        );

        $userRole->permissions()->sync(
            \App\Models\Permission::whereIn('name', [
                'clients.index', 'clients.show',
                'invoices.index', 'invoices.show',
                'tickets.index', 'tickets.create', 'tickets.store', 'tickets.show',
                'products.index', 'products.show',
                'orders.index', 'orders.show',
                'reports.index',
                'dashboard',
                'profile.edit', 'profile.update',
            ])->get()
        );
    }
}
