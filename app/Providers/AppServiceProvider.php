<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register dynamic gates for permissions
        // Only load if permissions table exists
        if (\Illuminate\Support\Facades\Schema::hasTable('permissions')) {
            $permissions = \App\Models\Permission::pluck('name')->toArray();

            foreach ($permissions as $permission) {
                \Illuminate\Support\Facades\Gate::define($permission, function ($user) use ($permission) {
                    return $user->hasPermission($permission);
                });
            }
        }
    }
}
