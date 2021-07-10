<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInternetConnectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $connected = @fsockopen("www.google.com", 80);
        if (!$connected) {
            abort(500);
        }
        fclose($connected);
        return $next($request);
    }
}
