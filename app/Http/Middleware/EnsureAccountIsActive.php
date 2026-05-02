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
        if (auth()->check()) {
            $user = auth()->user();

            // Check if profile is incomplete (missing key fields)
            $isIncomplete = empty($user->unit_kerja_id) ||
                (empty($user->nip) && empty($user->nik)) ||
                empty($user->jabatan);

            // If not active OR profile incomplete, force to pending page
            if (!$user->is_active || $isIncomplete) {
                if (
                    !$request->routeIs('pending.activation') &&
                    !$request->routeIs('pending.activation.submit') &&
                    !$request->routeIs('logout')
                ) {
                    return redirect()->route('pending.activation');
                }
            } else {
                // If user is active AND complete but trying to access pending page, redirect to dashboard
                if ($request->routeIs('pending.activation')) {
                    return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }
}
