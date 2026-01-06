<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk Terlaris | Admin BanyuGrowth</title>
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
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">
              <i class="bi bi-star-fill text-yellow-500"></i> Produk Terlaris
            </h2>
            <p class="text-gray-600 mt-1">10 produk dengan engagement terbaik (views + klik beli + likes)</p>
          </div>
          <a href="{{ route('admin.statistics.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          @forelse($topProducts as $index => $product)
          <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
            <div class="relative">
              @if($product->gambar)
              <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-64 object-cover">
              @else
              <div class="w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                <i class="bi bi-image text-6xl text-gray-400"></i>
              </div>
              @endif

              <!-- Ranking Badge -->
              <div class="absolute top-4 left-4">
                @if($index < 3) <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-white text-lg
                  {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-600') }} shadow-lg">
                  {{ $index + 1 }}
              </div>
              @else
              <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                {{ $index + 1 }}
              </div>
              @endif
            </div>

            <!-- Price Badge -->
            <div class="absolute bottom-4 right-4 bg-white px-4 py-2 rounded-full shadow-lg">
              <span class="font-bold text-green-600">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
            </div>
          </div>

          <div class="p-6">
            <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $product->nama_produk }}</h3>
            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->deskripsi, 100) }}</p>

            <!-- UMKM Info -->
            <div class="flex items-center gap-2 mb-4 pb-4 border-b">
              <i class="bi bi-shop text-blue-500"></i>
              <span class="font-semibold text-gray-700">{{ $product->umkm->nama_usaha }}</span>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-3 gap-4 mb-4">
              <div class="text-center p-3 bg-purple-50 rounded-lg">
                <i class="bi bi-eye-fill text-purple-500 text-xl"></i>
                <p class="font-bold text-gray-800 mt-1">{{ number_format($product->jumlah_view ?? 0) }}</p>
                <p class="text-xs text-gray-600">Views</p>
              </div>

              <div class="text-center p-3 bg-green-50 rounded-lg">
                <i class="bi bi-cart-fill text-green-500 text-xl"></i>
                <p class="font-bold text-gray-800 mt-1">{{ number_format($product->jumlah_klik_beli ?? 0) }}</p>
                <p class="text-xs text-gray-600">Clicks</p>
              </div>

              <div class="text-center p-3 bg-red-50 rounded-lg">
                <i class="bi bi-heart-fill text-red-500 text-xl"></i>
                <p class="font-bold text-gray-800 mt-1">{{ number_format($product->jumlah_like ?? 0) }}</p>
                <p class="text-xs text-gray-600">Likes</p>
              </div>
            </div>

            <!-- Engagement Score -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-lg p-4 mb-4">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm opacity-90">Engagement Score</p>
                  <p class="text-3xl font-bold">{{ number_format($product->engagement_score) }}</p>
                </div>
                <i class="bi bi-graph-up-arrow text-4xl opacity-75"></i>
              </div>
            </div>

            <!-- Action Button -->
            <a href="{{ route('admin.products.show', $product->id) }}" class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
              <i class="bi bi-eye"></i> Lihat Detail Produk
            </a>
          </div>
        </div>
        @empty
        <div class="col-span-2 text-center py-12 bg-white rounded-xl shadow-lg">
          <i class="bi bi-inbox text-6xl text-gray-300"></i>
          <p class="mt-4 text-gray-500">Belum ada data produk</p>
        </div>
        @endforelse
      </div>

      <!-- Summary Statistics -->
      @if($topProducts->count() > 0)
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-star-fill text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">Produk Teratas</h3>
          <p class="text-xl font-bold mt-2">{{ $topProducts->first()->nama_produk }}</p>
          <p class="text-yellow-100 text-sm mt-1">{{ number_format($topProducts->first()->engagement_score) }} engagement</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-eye-fill text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">Total Views</h3>
          <p class="text-2xl font-bold mt-2">{{ number_format($topProducts->sum('jumlah_view')) }}</p>
          <p class="text-purple-100 text-sm mt-1">Dari top 10 produk</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-cart-fill text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">Total Clicks</h3>
          <p class="text-2xl font-bold mt-2">{{ number_format($topProducts->sum('jumlah_klik_beli')) }}</p>
          <p class="text-green-100 text-sm mt-1">Klik tombol beli</p>
        </div>

        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-heart-fill text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">Total Likes</h3>
          <p class="text-2xl font-bold mt-2">{{ number_format($topProducts->sum('jumlah_like')) }}</p>
          <p class="text-red-100 text-sm mt-1">Total kesukaan</p>
        </div>
      </div>
      @endif

  </div>
  </main>
  </div>
</body>
</html>
