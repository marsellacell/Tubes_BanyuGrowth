<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductClick;
use Illuminate\Support\Facades\Storage;
use App\Services\NotificationService;

class UmkmProductController extends Controller
{
    // 🔹 Menampilkan daftar produk milik UMKM yang login
    public function index()
    {
        $umkmId = session('umkm_id');
        
        if (!$umkmId) {
            return redirect()->route('umkm.login.form')->with('error', 'Silakan login terlebih dahulu');
        }

        $products = Product::with('category')
            ->where('umkm_id', $umkmId)
            ->latest()
            ->get();

        return view('umkm.products.index', compact('products'));
    }

    // 🔹 Menampilkan detail produk
    public function show($id)
    {
        $product = Product::with(['umkm', 'category'])->findOrFail($id);

        // Track view - increment jumlah_view
        $product->incrementView();
        
        // Record click in product_clicks table
        ProductClick::create([
            'product_id' => $product->id,
            'umkm_id' => $product->umkm_id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'click_type' => 'view'
        ]);

        $produk = [
            'id' => $product->id,
            'nama' => $product->nama_produk,
            'umkm' => $product->umkm->nama_usaha ?? 'N/A',
            'image' => $product->image ?? '/assets/img/default-product.jpg',
            'harga' => $product->harga,
            'deskripsi' => $product->deskripsi,
            'lokasi' => $product->lokasi,
            'kategori' => $product->category->nama_kategori ?? 'Lainnya',
            'no_telepon' => $product->umkm->no_telepon ?? '-',
            'rating' => '4.8', // Bisa dikembangkan dengan sistem rating nanti
            'jumlah_view' => $product->jumlah_view,
            'jumlah_klik_beli' => $product->jumlah_klik_beli
        ];

        return view('umkm.detail', compact('produk'));
    }

    // 🔹 Track buy click (untuk redirect ke WhatsApp)
    public function trackBuyClick($id)
    {
        $product = Product::with('umkm')->findOrFail($id);

        // Increment klik beli
        $product->incrementKlikBeli();

        // Record click
        ProductClick::create([
            'product_id' => $product->id,
            'umkm_id' => $product->umkm_id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'click_type' => 'buy'
        ]);

        // Notify UMKM about product interest (every 5 clicks)
        if ($product->jumlah_klik_beli % 5 == 0) {
            NotificationService::productSold(
                $product->umkm_id,
                $product->nama_produk,
                $product->jumlah_klik_beli
            );
        }

        // Generate WhatsApp link
        $phoneNumber = preg_replace('/[^0-9]/', '', $product->umkm->no_telepon);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $message = urlencode("Halo, saya tertarik dengan produk *{$product->nama_produk}* seharga Rp" . number_format($product->harga, 0, ',', '.') . " dari {$product->umkm->nama_usaha}. Apakah produk masih tersedia?");
        
        $waLink = "https://wa.me/{$phoneNumber}?text={$message}";

        return redirect($waLink);
    }

    // ============================================
    // 🏪 UMKM AUTHENTICATED METHODS
    // ============================================

    // 🔹 Dashboard UMKM
    public function dashboard()
    {
        $umkmId = session('umkm_id');
        $products = Product::where('umkm_id', $umkmId)->get();
        
        $stats = [
            'total_products' => $products->count(),
            'total_views' => $products->sum('jumlah_view'),
            'total_clicks' => $products->sum('jumlah_klik_beli'),
            'active_products' => $products->where('status', 'active')->count(),
        ];

        return view('umkm.dashboard', compact('products', 'stats'));
    }

    // 🔹 Form create product
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('umkm.products.create', compact('categories'));
    }

    // 🔹 Store new product
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'lokasi' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'deskripsi.required' => 'Deskripsi produk wajib diisi',
            'harga.required' => 'Harga produk wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh kurang dari 0',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = $request->except('image');
        $data['umkm_id'] = session('umkm_id');
        $data['status'] = 'active';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('products', $filename, 'public');
            $data['image'] = '/storage/' . $path;
        } else {
            // Set default product image if no image uploaded
            $data['image'] = '/assets/img/default-product.jpg';
        }

        $product = Product::create($data);

        // Get UMKM name
        $umkm = \App\Models\Umkm::find(session('umkm_id'));
        
        // Notify all admins about new product
        NotificationService::notifyAllAdmins(
            'product_added',
            '📦 Produk Baru Ditambahkan',
            "{$umkm->nama_usaha} menambahkan produk baru: \"{$product->nama_produk}\".",
            '/admin/products'
        );

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 🔹 Form edit product
    public function edit($id)
    {
        $product = Product::where('umkm_id', session('umkm_id'))->findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('umkm.products.edit', compact('product', 'categories'));
    }

    // 🔹 Update product
    public function update(Request $request, $id)
    {
        $product = Product::where('umkm_id', session('umkm_id'))->findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'lokasi' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi',
            'deskripsi.required' => 'Deskripsi produk wajib diisi',
            'harga.required' => 'Harga produk wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh kurang dari 0',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists and not default
            if ($product->image && $product->image !== '/assets/img/default-product.jpg') {
                $oldPath = str_replace('/storage/', '', $product->image);
                Storage::disk('public')->delete($oldPath);
            }

            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('products', $filename, 'public');
            $data['image'] = '/storage/' . $path;
        }

        $product->update($data);

        // Get UMKM name
        $umkm = \App\Models\Umkm::find(session('umkm_id'));
        
        // Notify all admins about product update
        NotificationService::notifyAllAdmins(
            'product_updated',
            '✏️ Produk Diperbarui',
            "{$umkm->nama_usaha} memperbarui produk: \"{$product->nama_produk}\".",
            '/admin/products'
        );

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 🔹 Delete product
    public function destroy($id)
    {
        $product = Product::where('umkm_id', session('umkm_id'))->findOrFail($id);
        
        // Delete image from storage
        if ($product->image) {
            $oldPath = str_replace('/storage/', '', $product->image);
            Storage::disk('public')->delete($oldPath);
        }

        $product->delete();

        return redirect()->route('umkm.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    // 🔹 Statistics untuk UMKM
    public function statistics()
    {
        $umkmId = session('umkm_id');
        $products = Product::where('umkm_id', $umkmId)->get();
        
        $stats = [
            'total_views' => $products->sum('jumlah_view'),
            'total_likes' => $products->sum('jumlah_like'),
            'total_clicks' => $products->sum('jumlah_klik_beli'),
            'top_products' => $products->sortByDesc('jumlah_view')->take(5),
        ];

        return view('umkm.statistics', compact('stats'));
    }
}
