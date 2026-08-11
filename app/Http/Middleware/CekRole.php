<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user() && $request->user()->role === $role) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Akses Ditolak! Satpam Baja: Anda bukan Admin.'
        ], 403);
    }
}