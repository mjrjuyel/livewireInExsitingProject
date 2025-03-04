<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;

class CheckApiLoginTokenExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token not found'], Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = PersonalAccessToken::findToken($token);
        if (!$accessToken || ($accessToken->expires_at && now()->greaterThan($accessToken->expires_at))) {
            return response()->json(['message' => 'Token expired'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
