<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole('customer')) {
            return response()->json([
                'message' => 'Unauthorized. Customer access only.'
            ], 403);
        }

        return $next($request);
    }
}
