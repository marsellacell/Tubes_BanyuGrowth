<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUmkmAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if UMKM is authenticated via session
        if (!session()->has('umkm_id')) {
            return redirect('/umkm/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if UMKM is verified
        $umkmId = session('umkm_id');
        $umkm = \App\Models\Umkm::find($umkmId);
        
        if (!$umkm || $umkm->status_verifikasi !== 'approved') {
            session()->forget('umkm_id');
            return redirect('/umkm/login')->with('error', 'Akun Anda belum diverifikasi atau ditolak');
        }

        // Share UMKM data to all views
        view()->share('authUmkm', $umkm);

        return $next($request);
    }
}
