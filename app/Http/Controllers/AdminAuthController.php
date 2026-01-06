<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class AdminAuthController extends Controller
{
    public function showLogin() {
        return view('admin.login');
    }

    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $admin = User::where('username', $request->username)
                     ->where('role', 'admin')
                     ->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Session::put('admin_id', $admin->id);
            Session::put('admin_nama', $admin->nama_lengkap);
            return redirect('/admin/dashboard');
        } else {
            return back()->with('error', 'Username atau password salah!');
        }
    }

    public function logout() {
        Session::forget(['admin_id', 'admin_nama']);
        return redirect('/admin/login')->with('success', 'Logout berhasil!');
    }

    // ============================================
    // 🛡️ ADMIN DASHBOARD & STATISTICS
    // ============================================

    public function dashboard()
    {
        $stats = [
            'total_umkm' => \App\Models\Umkm::count(),
            'pending_umkm' => \App\Models\Umkm::where('status_verifikasi', 'pending')->count(),
            'approved_umkm' => \App\Models\Umkm::where('status_verifikasi', 'approved')->count(),
            'total_products' => \App\Models\Product::count(),
            'total_views' => \App\Models\Product::sum('jumlah_view'),
            'total_clicks' => \App\Models\Product::sum('jumlah_klik_beli'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function statistics()
    {
        $stats = [
            'total_umkm' => \App\Models\Umkm::count(),
            'total_products' => \App\Models\Product::count(),
            'total_views' => \App\Models\Product::sum('jumlah_view'),
            'total_clicks' => \App\Models\Product::sum('jumlah_klik_beli'),
            'monthly_registrations' => \App\Models\Umkm::whereMonth('created_at', date('m'))->count(),
        ];

        // Top UMKM by total views
        $topUmkm = \App\Models\Umkm::withCount(['products as total_views' => function($query) {
            $query->select(DB::raw('COALESCE(SUM(jumlah_view), 0)'));
        }])
        ->withCount(['products as total_likes' => function($query) {
            $query->select(DB::raw('COALESCE(SUM(jumlah_like), 0)'));
        }])
        ->orderBy('total_views', 'desc')
        ->take(5)
        ->get();

        // Top Products by views + likes + clicks
        $topProducts = \App\Models\Product::with('umkm')
            ->selectRaw('products.*, (jumlah_view + jumlah_klik_beli + jumlah_like) as engagement_score')
            ->orderByDesc('engagement_score')
            ->take(5)
            ->get();

        // Low engagement products
        $lowProducts = \App\Models\Product::with('umkm')
            ->whereRaw('(jumlah_view + jumlah_klik_beli + jumlah_like) < 5')
            ->orderByRaw('(jumlah_view + jumlah_klik_beli + jumlah_like) ASC')
            ->take(5)
            ->get();

        // UMKM Growth by Year (for chart)
        $umkmGrowth = \App\Models\Umkm::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        // UMKM by Category (for pie chart)
        $umkmByCategory = \App\Models\Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.nama_kategori as category, COUNT(DISTINCT products.umkm_id) as count')
            ->groupBy('categories.nama_kategori')
            ->get();

        return view('admin.statistics.index', compact('stats', 'topUmkm', 'topProducts', 'lowProducts', 'umkmGrowth', 'umkmByCategory'));
    }

    public function topUmkm()
    {
        $topUmkm = \App\Models\Umkm::withCount('products')
            ->withCount(['products as total_views' => function($query) {
                $query->select(DB::raw('COALESCE(SUM(jumlah_view), 0)'));
            }])
            ->withCount(['products as total_likes' => function($query) {
                $query->select(DB::raw('COALESCE(SUM(jumlah_like), 0)'));
            }])
            ->orderBy('total_views', 'desc')
            ->take(10)
            ->get();

        return view('admin.statistics.top-umkm', compact('topUmkm'));
    }

    public function topProducts()
    {
        $topProducts = \App\Models\Product::with('umkm')
            ->selectRaw('products.*, (jumlah_view + jumlah_klik_beli + jumlah_like) as engagement_score')
            ->orderByDesc('engagement_score')
            ->take(10)
            ->get();

        return view('admin.statistics.top-products', compact('topProducts'));
    }

    public function lowProducts()
    {
        $lowProducts = \App\Models\Product::with('umkm')
            ->selectRaw('products.*, (jumlah_view + jumlah_klik_beli + jumlah_like) as engagement_score')
            ->whereRaw('(jumlah_view + jumlah_klik_beli + jumlah_like) < 5')
            ->orderByRaw('(jumlah_view + jumlah_klik_beli + jumlah_like) ASC')
            ->take(10)
            ->get();

        return view('admin.statistics.low-products', compact('lowProducts'));
    }

    // ============================================
    // 🏪 UMKM VERIFICATION MANAGEMENT
    // ============================================

    public function umkmList()
    {
        $umkmList = \App\Models\Umkm::with('verifiedBy')->latest()->get();
        return view('admin.umkm.index', compact('umkmList'));
    }

    public function umkmPending()
    {
        $pendingList = \App\Models\Umkm::where('status_verifikasi', 'pending')
            ->latest()
            ->get();
        return view('admin.umkm.pending', compact('pendingList'));
    }

    public function umkmDetail($id)
    {
        $umkm = \App\Models\Umkm::with(['products', 'verifiedBy'])->findOrFail($id);
        return view('admin.umkm.show', compact('umkm'));
    }

    public function approveUmkm($id)
    {
        $umkm = \App\Models\Umkm::findOrFail($id);
        $umkm->update([
            'status_verifikasi' => 'approved',
            'verified_by' => session('admin_id'),
            'verified_at' => now(),
        ]);

        // Notify UMKM that they are verified
        NotificationService::umkmVerified($umkm->id, $umkm->nama_usaha);

        return redirect()->back()->with('success', 'UMKM berhasil diverifikasi!');
    }

    public function rejectUmkm($id)
    {
        $umkm = \App\Models\Umkm::findOrFail($id);
        $umkm->update([
            'status_verifikasi' => 'rejected',
            'verified_by' => session('admin_id'),
            'verified_at' => now(),
        ]);

        // Notify UMKM that they are rejected
        NotificationService::umkmRejected($umkm->id, $umkm->nama_usaha);

        return redirect()->back()->with('success', 'UMKM berhasil ditolak!');
    }

    // ============================================
    // 📦 PRODUCT MANAGEMENT
    // ============================================

    public function productList()
    {
        $products = \App\Models\Product::with(['umkm', 'category'])->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function productDetail($id)
    {
        $product = \App\Models\Product::with(['umkm', 'category'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function editProduct($id)
    {
        $product = \App\Models\Product::with(['umkm', 'category'])->findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.show', $product->id)
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function deleteProduct($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
