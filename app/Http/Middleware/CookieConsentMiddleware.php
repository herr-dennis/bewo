<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CookieConsentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Prüfe, ob der Nutzer eine Zustimmung zu Cookies gegeben hat
        $cookiesAccepted = $request->cookie('cookiesAccepted');

        return $next($request);
    }
}
