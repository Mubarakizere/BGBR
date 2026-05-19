<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Referrer details
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Legacy XSS protection
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Permissions policy to lock down device APIs
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), interest-cohort=()');

        // Content Security Policy
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173; " .
               "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net; " .
               "img-src 'self' data: http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173 https://images.unsplash.com; " .
               "connect-src 'self' ws://localhost:5173 ws://127.0.0.1:5173 ws://[::1]:5173 http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173; " .
               "frame-src 'none'; " .
               "object-src 'none';";
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
