<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class NoCacheMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, max-age=0, must-revalidate, no-store');
        $response->headers->set('charset', 'utf8');

        $now = Carbon::now();
        $response->headers->set('Expires', $now->format('D, d M Y H:i:s T'));

        return $response;
    }
}
