<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApi
{
    public function handle(Request $request, Closure $next)
    {
        \Log::info('AuthApi Middleware: Token - ' . $request->bearerToken());
        \Log::info('AuthApi Middleware: User - ' . (Auth::guard('api')->check() ? Auth::guard('api')->id() : 'None'));

        if (!Auth::guard('api')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        return $next($request);
    }
}