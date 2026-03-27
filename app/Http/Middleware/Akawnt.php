<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Akawnt
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Example condition: require ?access=1 in URL
        if (!$request->has('access')) {
            return redirect('/home');
        }

        return $next($request);
    }
}
