<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class SaveLastActionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        return $next($request);
    }

    public function terminate($request, $response)
    {
        if (auth()->check()) {
            auth()->user()->update([
                'save_last_action' => Carbon::now(),
            ]);
        }
    }
}
