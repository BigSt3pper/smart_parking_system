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
        // Check if user is authenticated and is admin
        if (!Auth::check()) {
            return redirect('/admin/login');
        }

        if (Auth::user()->role !== 'Admin') {
            return redirect('/')->with('error', 'Access denied. Admin only.');
        }

        return $next($request);
    }
}
