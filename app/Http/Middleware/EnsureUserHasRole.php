<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();

        // If user is unverified, restrict access to only profile and logout
        if ($user->verification_status === 'UNVERIFIED' && 
            !$request->routeIs('profile') && 
            !$request->routeIs('logout')) {
            return redirect()->route('profile')->with('status', 'Akun Anda belum diverifikasi. Harap lengkapi profil Anda.');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
