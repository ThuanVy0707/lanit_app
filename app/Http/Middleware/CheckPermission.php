<?php

namespace App\Http\Middleware;

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

        return $next($request);
    }
}
