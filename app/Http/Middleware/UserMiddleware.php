<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isUser()) {
            return $next($request);
        }

        return redirect('/admin/dashboard')->with('error', 'Access denied.');
    }
}