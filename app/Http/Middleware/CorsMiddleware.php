<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Izinkan akses dari semua domain (*)
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

        // Jika request adalah OPTIONS, langsung return response kosong
        if ($request->isMethod('OPTIONS')) {
            return response()->json([], 204);
        }

        return $response;
    }
}
