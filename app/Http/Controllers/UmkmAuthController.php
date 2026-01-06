<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;


class UmkmAuthController extends Controller
{
    // tampil form register
    public function showRegister()
    {
        return view('umkm.register');
    }

    // proses register
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:255',
            'email' => 'required|email|unique:umkms,email',
            'no_telepon' => 'required|string|max:20',
            'username' => 'required|string|unique:umkms,username|max:255',
            'password' => 'required|string|min:6|confirmed'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_usaha.required' => 'Nama usaha wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $umkm = Umkm::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nama_usaha' => $request->nama_usaha,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status_verifikasi' => 'pending' // default pending
        ]);

        // Notify all admins about new UMKM registration
        NotificationService::notifyAllAdmins(
            'umkm_registered',
            '📝 UMKM Baru Mendaftar',
            "{$umkm->nama_usaha} telah mendaftar dan menunggu verifikasi Anda.",
            '/admin/umkm/pending'
        );

        return redirect('/umkm/login')->with('success', 'Pendaftaran berhasil! Akun Anda akan diverifikasi oleh admin.');
    }

    // tampil form login
    public function showLogin()
    {
        return view('umkm.login');
    }

    // proses login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $umkm = Umkm::where('username', $request->username)->first();

        if (!$umkm) {
            return back()->with('error', 'Username atau Password salah!');
        }

        if (!Hash::check($request->password, $umkm->password)) {
            return back()->with('error', 'Username atau Password salah!');
        }

        // Check verification status
        if ($umkm->status_verifikasi === 'pending') {
            return back()->with('error', 'Akun Anda masih menunggu verifikasi dari admin.');
        }

        if ($umkm->status_verifikasi === 'rejected') {
            return back()->with('error', 'Akun Anda ditolak oleh admin.');
        }

        // Login success
        Session::put('umkm_id', $umkm->id);
        Session::put('umkm_nama', $umkm->nama_lengkap);
        Session::put('umkm_usaha', $umkm->nama_usaha);
        
        return redirect()->route('umkm.dashboard');
    }

    // logout
    public function logout()
    {
        Session::forget(['umkm_id', 'umkm_nama', 'umkm_usaha']);
        return redirect('/umkm/login')->with('success', 'Logout berhasil!');
    }

    public function detailProduk($id)
    {
        $produk = [
            "nama" => "Brownies Coklat Premium",
            "harga" => 25000,
            "deskripsi" => "Brownies panggang premium olahan coklat kualitas tinggi",
            "image" => "/assets/img/contoh_produk.jpg"
        ];

        return view('umkm.detail', compact('produk'));
    }

    // Edit Profile
    public function editProfile()
    {
        $umkm = Umkm::findOrFail(Session::get('umkm_id'));
        return view('umkm.profile.edit', compact('umkm'));
    }

    // Update Profile
    public function updateProfile(Request $request)
    {
        $umkm = Umkm::findOrFail(Session::get('umkm_id'));

        $rules = [
            'nama_lengkap' => 'required|string|max:255',
            'nama_usaha' => 'required|string|max:255',
            'email' => 'required|email|unique:umkms,email,' . $umkm->id,
            'no_telepon' => 'required|string|max:20',
            'logo_umkm' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ];

        $messages = [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'nama_usaha.required' => 'Nama usaha wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_telepon.required' => 'Nomor telepon wajib diisi',
            'logo_umkm.image' => 'File harus berupa gambar',
            'logo_umkm.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'logo_umkm.max' => 'Ukuran gambar maksimal 2MB',
        ];

        // Jika password diisi, validasi password
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:6|confirmed';
            $messages['password.min'] = 'Password minimal 6 karakter';
            $messages['password.confirmed'] = 'Konfirmasi password tidak cocok';
        }

        $request->validate($rules, $messages);

        // Update data
        $updateData = [
            'nama_lengkap' => $request->nama_lengkap,
            'nama_usaha' => $request->nama_usaha,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
        ];

        // Handle logo upload
        if ($request->hasFile('logo_umkm')) {
            // Delete old logo if exists
            if ($umkm->logo_umkm && Storage::disk('public')->exists($umkm->logo_umkm)) {
                Storage::disk('public')->delete($umkm->logo_umkm);
            }

            $logoPath = $request->file('logo_umkm')->store('logos', 'public');
            $updateData['logo_umkm'] = $logoPath;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $umkm->update($updateData);

        // Update session nama usaha jika berubah
        Session::put('umkm_nama', $umkm->nama_lengkap);
        Session::put('umkm_usaha', $umkm->nama_usaha);

        // Notify all admins about profile update
        NotificationService::notifyAllAdmins(
            'profile_updated',
            '👤 Profil UMKM Diperbarui',
            "{$umkm->nama_usaha} telah memperbarui informasi profil mereka.",
            '/admin/umkm'
        );

        return redirect()->route('umkm.profile.edit')->with('success', 'Profile berhasil diperbarui!');
    }

        // =================================================
    // TAMBAHAN UNTUK TUGAS LAPORAN PRAKTIKUM (INSERT)
    // =================================================

    // Insert UMKM menggunakan Raw SQL
    public function insertUmkmRawSQL()
    {
        DB::insert(
            'INSERT INTO umkms (nama_lengkap, nama_usaha, email, no_telepon, username, password, status_verifikasi, created_at, updated_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())',
            [
                'UMKM Raw SQL',
                'Usaha Raw',
                'rawsql@example.com',
                '0811111111',
                'umkmraw',
                Hash::make('password123'),
                'pending'
            ]
        );

        return 'Insert UMKM dengan Raw SQL berhasil';
    }

    // Insert UMKM menggunakan Query Builder
    public function insertUmkmQueryBuilder()
    {
        DB::table('umkms')->insert([
            'nama_lengkap'      => 'UMKM Query Builder',
            'nama_usaha'        => 'Usaha QB',
            'email'             => 'qb@example.com',
            'no_telepon'        => '0822222222',
            'username'          => 'umkmqb',
            'password'          => Hash::make('password123'),
            'status_verifikasi' => 'pending',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return 'Insert UMKM dengan Query Builder berhasil';
    }

    // Insert UMKM menggunakan Eloquent ORM
    public function insertUmkmEloquent()
    {
        Umkm::create([
            'nama_lengkap'      => 'UMKM Eloquent',
            'nama_usaha'        => 'Usaha Eloquent',
            'email'             => 'eloquent@example.com',
            'no_telepon'        => '0833333333',
            'username'          => 'umkmelo',
            'password'          => Hash::make('password123'),
            'status_verifikasi' => 'pending',
        ]);

        return 'Insert UMKM dengan Eloquent ORM berhasil';
    }

}