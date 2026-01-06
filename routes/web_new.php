<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UmkmProductController;

// ============================================
// 🌐 GUEST ROUTES (Public - No Auth Required)
// ============================================

Route::get('/', function () {
    return view('welcome');
});

// Browse & Search Products (Guest)
Route::get('/umkm/home', [HomeController::class, 'index'])->name('umkm.home');
Route::get('/umkm/search', [HomeController::class, 'search'])->name('umkm.search');

// Product Detail & Buy (Guest)
Route::get('/umkm/produk/{id}', [UmkmProductController::class, 'show'])->name('umkm.detail');
Route::get('/umkm/produk/{id}/beli', [UmkmProductController::class, 'trackBuyClick'])->name('umkm.buy');

// Static Pages
Route::get('/umkm/informasi/{id}', fn($id) => view('umkm.informasi', ['id' => $id]));
Route::get('/umkm/faq', fn() => view('umkm.faq'));

// ============================================
// 🔐 UMKM AUTH ROUTES (Public Auth Pages)
// ============================================

Route::get('/umkm/register', [UmkmAuthController::class, 'showRegister']);
Route::post('/umkm/register', [UmkmAuthController::class, 'register']);
Route::get('/umkm/login', [UmkmAuthController::class, 'showLogin']);
Route::post('/umkm/login', [UmkmAuthController::class, 'login']);

// ============================================
// 🏪 UMKM PROTECTED ROUTES (Authenticated UMKM Only)
// ============================================

Route::middleware(['App\Http\Middleware\EnsureUmkmAuthenticated'])->group(function () {
    Route::get('/umkm/logout', [UmkmAuthController::class, 'logout']);
    
    // UMKM Dashboard & Profile (Uncomment saat controller sudah dibuat)
    // Route::get('/umkm/dashboard', [UmkmDashboardController::class, 'index'])->name('umkm.dashboard');
    // Route::get('/umkm/profil', [UmkmProfileController::class, 'show'])->name('umkm.profile');
    // Route::get('/umkm/edit-profil', [UmkmProfileController::class, 'edit'])->name('umkm.profile.edit');
    // Route::post('/umkm/edit-profil', [UmkmProfileController::class, 'update'])->name('umkm.profile.update');
    
    // UMKM Product Management (CRUD) - (Uncomment saat controller sudah dibuat)
    // Route::resource('/umkm/my-products', UmkmProductManagementController::class);
});

// ============================================
// 👤 ADMIN AUTH ROUTES (Public Auth Pages)
// ============================================

Route::get('/admin/login', [AdminAuthController::class, 'showLogin']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// ============================================
// 🛡️ ADMIN PROTECTED ROUTES (Authenticated Admin Only)
// ============================================

Route::middleware(['App\Http\Middleware\EnsureAdminAuthenticated'])->group(function () {
    Route::get('/admin/logout', [AdminAuthController::class, 'logout']);
    
    // Admin Dashboard & Statistics (Uncomment saat controller sudah dibuat)
    // Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // UMKM Verification Management (Uncomment saat controller sudah dibuat)
    // Route::get('/admin/umkm', [AdminUmkmController::class, 'index'])->name('admin.umkm.index');
    // Route::get('/admin/umkm/pending', [AdminUmkmController::class, 'pending'])->name('admin.umkm.pending');
    // Route::post('/admin/umkm/{id}/approve', [AdminUmkmController::class, 'approve'])->name('admin.umkm.approve');
    // Route::post('/admin/umkm/{id}/reject', [AdminUmkmController::class, 'reject'])->name('admin.umkm.reject');
    
    // Product Management (Uncomment saat controller sudah dibuat)
    // Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    
    // Category Management (Uncomment saat controller sudah dibuat)
    // Route::resource('/admin/categories', AdminCategoryController::class);
    
    // Statistics & Reports (Uncomment saat controller sudah dibuat)
    // Route::get('/admin/statistics', [AdminStatisticsController::class, 'index'])->name('admin.statistics');
});
