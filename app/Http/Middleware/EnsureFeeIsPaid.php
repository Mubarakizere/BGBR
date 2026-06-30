<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFeeIsPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->hasRole('Super Admin')) {
            if (!$user->fee_valid_until || $user->fee_valid_until < now()) {
                if (!$request->routeIs('fee.pay') && !$request->routeIs('fee.store') && !$request->routeIs('logout')) {
                    return redirect()->route('fee.pay');
                }
            }
        }

        return $next($request);
    }
}
