<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
  @include('components.sweetalert')
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.admin-sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8 pt-20 lg:pt-8">
      <div class="max-w-7xl mx-auto mb-8">
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Dashboard Admin</h2>
          <p class="text-gray-600 mt-1">Selamat datang, <strong>{{ session('admin_nama') }}</strong></p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
          {{ session('success') }}
        </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total UMKM</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_umkm'] }}</p>
              </div>
              <i class="bi bi-shop text-4xl text-blue-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Pending Verifikasi</p>
                <p class="text-2xl font-bold text-orange-600">{{ $stats['pending_umkm'] }}</p>
              </div>
              <i class="bi bi-clock-history text-4xl text-orange-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">UMKM Terverifikasi</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['approved_umkm'] }}</p>
              </div>
              <i class="bi bi-check-circle text-4xl text-green-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
              </div>
              <i class="bi bi-box-seam text-4xl text-purple-500"></i>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-500 text-sm">Total Produk</p>
              <p class="text-3xl font-bold text-purple-600">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-purple-100 p-4 rounded-full">
              <i class="bi bi-box-seam text-purple-600 text-2xl"></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Activity Stats -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Produk</h3>
          <div class="space-y-4">
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Total Views</span>
              <span class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_views']) }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Total Clicks (Beli)</span>
              <span class="text-2xl font-bold text-green-600">{{ number_format($stats['total_clicks']) }}</span>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h3>
          <div class="space-y-3">
            <a href="/admin/umkm/pending" class="block w-full bg-orange-500 hover:bg-orange-600 text-white text-center py-3 rounded-lg transition">
              <i class="bi bi-clock-history mr-2"></i>
              Verifikasi UMKM ({{ $stats['pending_umkm'] }})
            </a>
            <a href="/admin/umkm" class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-3 rounded-lg transition">
              <i class="bi bi-shop mr-2"></i>
              Lihat Semua UMKM
            </a>
            <a href="/admin/statistics" class="block w-full bg-purple-500 hover:bg-purple-600 text-white text-center py-3 rounded-lg transition">
              <i class="bi bi-graph-up mr-2"></i>
              Lihat Laporan Statistik
            </a>
          </div>
        </div>
      </div>
    </main>
  </div>

</body>
</html>
