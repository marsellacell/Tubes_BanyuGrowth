<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductClick;
use App\Models\Information;
use App\Services\NotificationService;

class HomeController extends Controller
{
    public function index()
    {
        // Get top 3 recommended products based on views, purchases, and likes
        $produkList = Product::with(['umkm', 'category'])
            ->where('status', 'active')
            ->whereHas('umkm', function($query) {
                $query->where('status_verifikasi', 'approved');
            })
            ->selectRaw('products.*, (jumlah_view + jumlah_klik_beli + jumlah_like) as recommendation_score')
            ->orderByDesc('recommendation_score')
            ->take(3)
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_produk,
                    'deskripsi' => $product->deskripsi,
                    'harga' => $product->harga,
                    'image' => $product->image ?? '/assets/img/default-product.jpg',
                    'umkm' => $product->umkm->nama_usaha ?? 'N/A',
                    'kategori' => $product->category->nama_kategori ?? 'Lainnya',
                    'jumlah_like' => $product->jumlah_like,
                    'jumlah_view' => $product->jumlah_view,
                    'jumlah_klik_beli' => $product->jumlah_klik_beli
                ];
            });

        // Get all categories
        $categories = Category::withCount('products')->get();

        // Get latest 5 published informations for homepage
        $informations = Information::where('is_published', true)
            ->latest()
            ->take(5)
            ->get();

        // Get top UMKM (berdasarkan total views produk) - only 3 for homepage
        $topUmkm = \App\Models\Umkm::where('status_verifikasi', 'approved')
            ->withCount(['products as total_views' => function($query) {
                $query->selectRaw('SUM(jumlah_view)');
            }])
            ->withCount('products')
            ->orderBy('total_views', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('produkList', 'categories', 'topUmkm', 'informations'));
    }

    // Show single information detail
    public function showInformation($slug)
    {
        $information = Information::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        
        // Get other informations (exclude current)
        $otherInformations = Information::where('is_published', true)
            ->where('id', '!=', $information->id)
            ->latest()
            ->take(5)
            ->get();

        return view('umkm.informasi', compact('information', 'otherInformations'));
    }

    public function allUmkm()
    {
        // Get all approved UMKM
        $umkmList = \App\Models\Umkm::where('status_verifikasi', 'approved')
            ->withCount(['products as total_views' => function($query) {
                $query->selectRaw('SUM(jumlah_view)');
            }])
            ->withCount('products')
            ->orderBy('total_views', 'desc')
            ->get();

        return view('umkm.all', compact('umkmList'));
    }

    public function umkmProfile($id)
    {
        // Get UMKM with products
        $umkm = \App\Models\Umkm::where('id', $id)
            ->where('status_verifikasi', 'approved')
            ->withCount(['products as total_views' => function($query) {
                $query->selectRaw('SUM(jumlah_view)');
            }])
            ->withCount('products')
            ->firstOrFail();

        // Get all products from this UMKM
        $products = Product::where('umkm_id', $id)
            ->where('status', 'active')
            ->with('category')
            ->latest()
            ->get();

        return view('umkm.profile', compact('umkm', 'products'));
    }

    public function allProducts()
    {
        // Get all active products with UMKM and category relations
        $produkList = Product::with(['umkm', 'category'])
            ->where('status', 'active')
            ->whereHas('umkm', function($query) {
                $query->where('status_verifikasi', 'approved');
            })
            ->latest()
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_produk,
                    'deskripsi' => $product->deskripsi,
                    'harga' => $product->harga,
                    'image' => $product->image ?? '/assets/img/default-product.jpg',
                    'umkm' => $product->umkm->nama_usaha ?? 'N/A',
                    'kategori' => $product->category->nama_kategori ?? 'Lainnya',
                    'jumlah_like' => $product->jumlah_like ?? 0
                ];
            });

        return view('products.index', compact('produkList'));
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $query = Product::with(['umkm', 'category'])
            ->where('status', 'active')
            ->whereHas('umkm', function($q) {
                $q->where('status_verifikasi', 'approved');
            });

        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('nama_produk', 'like', '%' . $keyword . '%')
                  ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                  ->orWhereHas('umkm', function($umkmQuery) use ($keyword) {
                      $umkmQuery->where('nama_usaha', 'like', '%' . $keyword . '%');
                  })
                  ->orWhereHas('category', function($catQuery) use ($keyword) {
                      $catQuery->where('nama_kategori', 'like', '%' . $keyword . '%');
                  });
            });
        }

        $produkList = $query->latest()
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_produk,
                    'deskripsi' => $product->deskripsi,
                    'harga' => $product->harga,
                    'image' => $product->image ?? '/assets/img/default-product.jpg',
                    'umkm' => $product->umkm->nama_usaha ?? 'N/A',
                    'umkm_id' => $product->umkm->id ?? null,
                    'kategori' => $product->category->nama_kategori ?? 'Lainnya',
                    'jumlah_like' => $product->jumlah_like ?? 0
                ];
            });

        // Get unique UMKMs from the search results
        $umkmList = collect();
        if ($keyword) {
            $umkmList = \App\Models\Umkm::where('status_verifikasi', 'approved')
                ->where(function($q) use ($keyword) {
                    $q->where('nama_usaha', 'like', '%' . $keyword . '%')
                      ->orWhere('nama_lengkap', 'like', '%' . $keyword . '%')
                      ->orWhere('email', 'like', '%' . $keyword . '%');
                })
                ->withCount('products')
                ->get();
        }

        return view('search', [
            'produkList' => $produkList,
            'umkmList' => $umkmList,
            'searchQuery' => $keyword
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['umkm', 'category'])->findOrFail($id);
        
        // Increment view count
        $product->incrementView();

        return view('umkm.produk_detail', compact('product'));
    }

    public function buyNow($id)
    {
        $product = Product::with('umkm')->findOrFail($id);

        // Increment click count
        $product->incrementKlikBeli();

        // Record click in analytics
        ProductClick::create([
            'product_id' => $product->id,
            'umkm_id' => $product->umkm_id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'click_type' => 'buy'
        ]);

        // Generate WhatsApp link
        $phoneNumber = preg_replace('/[^0-9]/', '', $product->umkm->no_telepon);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }

        $message = urlencode("Halo, saya tertarik dengan produk *{$product->nama_produk}* seharga Rp" . number_format($product->harga, 0, ',', '.') . " dari {$product->umkm->nama_usaha}. Apakah produk masih tersedia?");
        
        $waLink = "https://wa.me/{$phoneNumber}?text={$message}";

        return redirect($waLink);
    }

    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $produkList = Product::with(['umkm', 'category'])
            ->where('status', 'active')
            ->where('category_id', $category->id)
            ->whereHas('umkm', function($query) {
                $query->where('status_verifikasi', 'approved');
            })
            ->latest()
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_produk,
                    'deskripsi' => $product->deskripsi,
                    'harga' => $product->harga,
                    'image' => $product->image ?? '/assets/img/default-product.jpg',
                    'umkm' => $product->umkm->nama_usaha ?? 'N/A',
                    'kategori' => $product->category->nama_kategori ?? 'Lainnya',
                    'jumlah_like' => $product->jumlah_like ?? 0
                ];
            });

        // Get all categories for navigation
        $categories = Category::withCount('products')->get();

        return view('category', [
            'produkList' => $produkList,
            'categories' => $categories,
            'selectedCategory' => $category
        ]);
    }

    public function likeProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Increment like count
        $product->increment('jumlah_like');

        // Notify UMKM about product like (every 10 likes)
        if ($product->jumlah_like % 10 == 0) {
            NotificationService::productLiked(
                $product->umkm_id,
                $product->nama_produk,
                $product->jumlah_like
            );
        }

        return response()->json([
            'success' => true,
            'likes' => $product->jumlah_like,
            'message' => 'Produk disukai!'
        ]);
    }
}

