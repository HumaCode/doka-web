<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->is_active) {
            // Jika user mencoba mengakses halaman selain pending-activation atau logout
            if (!$request->routeIs('pending.activation') && !$request->routeIs('logout')) {
                return redirect()->route('pending.activation');
            }
        }

        // Jika user SUDAH aktif tapi mencoba akses halaman pending-activation
        if (auth()->check() && auth()->user()->is_active && $request->routeIs('pending.activation')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
