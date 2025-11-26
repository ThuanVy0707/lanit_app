<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $permission = null): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // If no specific permission provided, use route name as permission
        if (! $permission) {
            $permission = $request->route()->getName();
        }

        if (! $request->user()->hasPermission($permission)) {
            abort(403, 'Unauthorized. Required permission: '.$permission);
        }

        // Additional check for client-specific routes
        if ($this->isClientSpecificRoute($permission) && $request->route('client')) {
            $client = $request->route('client');
            $clientId = $client instanceof \App\Models\Client ? $client->id : $client;
            if (! $this->userCanAccessClient($request->user(), $clientId)) {
                abort(403, 'Unauthorized. You do not have access to this client.');
            }
        }

        return $next($request);
    }

    private function isClientSpecificRoute(string $permission): bool
    {
        return in_array($permission, [
            'clients.show',
            'clients.edit',
            'clients.update',
            'clients.destroy',
        ]);
    }

    private function userCanAccessClient($user, int $clientId): bool
    {
        // Admin can access all clients
        if ($user->hasRole('admin')) {
            return true;
        }

        // Check if user is assigned to this client
        return $user->assignedClients()->where('clients.id', $clientId)->exists();
    }
}
