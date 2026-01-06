<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if Admin is authenticated via session
        if (!session()->has('admin_id')) {
            return redirect('/admin/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Verify admin exists and has admin role
        $adminId = session('admin_id');
        $admin = \App\Models\User::find($adminId);
        
        if (!$admin || $admin->role !== 'admin') {
            session()->forget('admin_id');
            return redirect('/admin/login')->with('error', 'Akses ditolak');
        }

        // Share admin data to all views
        view()->share('authAdmin', $admin);

        return $next($request);
    }
}
