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
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Kalau belum login → redirect ke login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // Kalau role cocok → lanjut
        if ($request->user()->role === $role) {
            return $next($request);
        }

        // Kalau role tidak cocok → error 403
        abort(403);
    }
}
