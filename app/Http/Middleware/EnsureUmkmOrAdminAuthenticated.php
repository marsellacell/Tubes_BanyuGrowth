<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUmkmOrAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is either UMKM or Admin
        $isUmkm = session('umkm_id') !== null;
        $isAdmin = session('admin_id') !== null;

        if (!$isUmkm && !$isAdmin) {
            // If AJAX request, return JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            
            // Otherwise redirect to landing page
            return redirect()->route('landing');
        }

        return $next($request);
    }
}
