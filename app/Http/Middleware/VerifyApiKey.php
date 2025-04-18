<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $providedKey = $request->header('X-API-KEY');

        if ($providedKey !== config('api.access_key')) {
            return response()->json(['message' => 'Unauthorized. You are not allowed to access this resource.'], 401);
        }

        return $next($request);
    }
}
