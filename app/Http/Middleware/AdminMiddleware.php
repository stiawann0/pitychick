<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Gunakan Spatie Permission - PASTIKAN INI
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}