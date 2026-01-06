<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UmkmAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UmkmProductController;
use App\Http\Controllers\AdminInformationController;
use App\Http\Controllers\NotificationController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Public Access)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', fn() => view('auth.landing'))->name('landing');
Route::get('/umkm-list', [HomeController::class, 'allUmkm'])->name('umkm.all');
Route::get('/umkm-profile/{id}', [HomeController::class, 'umkmProfile'])->name('umkm.profile');

// Guest - Information
Route::get('/informasi/{slug}', [HomeController::class, 'showInformation'])->name('information.show');

// Notifications (Protected - for UMKM and Admin only)
Route::middleware(['auth.umkm.or.admin'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    Route::delete('/notifications/delete-read', [NotificationController::class, 'deleteAllRead']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
});

// Guest - Browse & Search Products
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [HomeController::class, 'allProducts'])->name('index');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/{id}', [HomeController::class, 'show'])->name('show');
    Route::post('/{id}/buy', [HomeController::class, 'buyNow'])->name('buy'); // Redirect ke WhatsApp
    Route::post('/{id}/like', [HomeController::class, 'likeProduct'])->name('like'); // Like product
});

// Guest - Browse by Category
Route::get('/categories/{slug}', [HomeController::class, 'byCategory'])->name('categories.show');

// Guest - FAQ & Info
Route::get('/faq', fn() => view('umkm.faq'))->name('faq');
Route::get('/about', fn() => view('auth.landing'))->name('about');

/*
|--------------------------------------------------------------------------
| UMKM Authentication Routes
|--------------------------------------------------------------------------
*/

Route::prefix('umkm')->name('umkm.')->group(function () {
    // Auth Routes
    Route::middleware('guest')->group(function () {
        Route::get('/register', [UmkmAuthController::class, 'showRegister'])->name('register.form');
        Route::post('/register', [UmkmAuthController::class, 'register'])->name('register');
        Route::get('/login', [UmkmAuthController::class, 'showLogin'])->name('login.form');
        Route::post('/login', [UmkmAuthController::class, 'login'])->name('login');
    });

    Route::get('/logout', [UmkmAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| UMKM Dashboard Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('umkm')->name('umkm.')->middleware(['auth.umkm'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UmkmProductController::class, 'dashboard'])->name('dashboard');
    
    // Product Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [UmkmProductController::class, 'index'])->name('index');
        Route::get('/create', [UmkmProductController::class, 'create'])->name('create');
        Route::post('/', [UmkmProductController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UmkmProductController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UmkmProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [UmkmProductController::class, 'destroy'])->name('destroy');
    });

    // UMKM Statistics
    Route::get('/statistics', [UmkmProductController::class, 'statistics'])->name('statistics');

    // UMKM Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [UmkmAuthController::class, 'editProfile'])->name('edit');
        Route::put('/update', [UmkmAuthController::class, 'updateProfile'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login.form');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login');
    });

    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth.admin'])->group(function () {
    // Dashboard with Statistics
    Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
    
    // UMKM Verification Management
    Route::prefix('umkm')->name('umkm.')->group(function () {
        Route::get('/', [AdminAuthController::class, 'umkmList'])->name('index');
        Route::get('/pending', [AdminAuthController::class, 'umkmPending'])->name('pending');
        Route::post('/{id}/approve', [AdminAuthController::class, 'approveUmkm'])->name('approve');
        Route::post('/{id}/reject', [AdminAuthController::class, 'rejectUmkm'])->name('reject');
        Route::get('/{id}', [AdminAuthController::class, 'umkmDetail'])->name('show');
    });

    // Product Management (Admin can view all products)
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [AdminAuthController::class, 'productList'])->name('index');
        Route::get('/{id}', [AdminAuthController::class, 'productDetail'])->name('show');
        Route::get('/{id}/edit', [AdminAuthController::class, 'editProduct'])->name('edit');
        Route::put('/{id}', [AdminAuthController::class, 'updateProduct'])->name('update');
        Route::delete('/{id}', [AdminAuthController::class, 'deleteProduct'])->name('destroy');
    });

    // Statistics & Reports
    Route::prefix('statistics')->name('statistics.')->group(function () {
        Route::get('/', [AdminAuthController::class, 'statistics'])->name('index');
        Route::get('/umkm-terlaris', [AdminAuthController::class, 'topUmkm'])->name('top-umkm');
        Route::get('/produk-terlaris', [AdminAuthController::class, 'topProducts'])->name('top-products');
        Route::get('/produk-kurang-diminati', [AdminAuthController::class, 'lowProducts'])->name('low-products');
    });

    // Information Management
    Route::prefix('information')->name('information.')->group(function () {
        Route::get('/', [AdminInformationController::class, 'index'])->name('index');
        Route::get('/create', [AdminInformationController::class, 'create'])->name('create');
        Route::post('/', [AdminInformationController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminInformationController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminInformationController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminInformationController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle-publish', [AdminInformationController::class, 'togglePublish'])->name('togglePublish');
    });

    // Category Management
    Route::resource('categories', AdminAuthController::class);
});

//LAPPRAK MODUL 12//
Route::get('/test-insert-eloquent', [UmkmAuthController::class, 'insertUmkmEloquent']);
Route::get('/test-insert-raw', [UmkmAuthController::class, 'insertUmkmRawSQL']);
Route::get('/test-insert-qb', [UmkmAuthController::class, 'insertUmkmQueryBuilder']);
