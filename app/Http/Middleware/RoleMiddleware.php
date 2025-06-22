<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/RoleMiddleware.php
    public function handle(Request $req, Closure $next, string $roles)
    {
        if (! $req->user()?->hasAnyRole(explode('|', $roles))) {
            \Log::warning("Unauthorized access by user {$req->user()->id} for role {$roles}");
            abort(403, 'Gak punya akses.');
        }
        return $next($req);
    }

}
