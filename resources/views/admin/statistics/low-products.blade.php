<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produk Kurang Diminati | Admin BanyuGrowth</title>
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
              <i class="bi bi-exclamation-triangle text-orange-500"></i> Produk Kurang Diminati
            </h2>
            <p class="text-gray-600 mt-1">10 produk dengan engagement rendah yang perlu perhatian khusus</p>
          </div>
          <a href="{{ route('admin.statistics.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

        <!-- Alert Info -->
        <div class="bg-orange-50 border-l-4 border-orange-500 p-6 mb-6 rounded-lg">
          <div class="flex items-start gap-3">
            <i class="bi bi-info-circle text-orange-500 text-2xl"></i>
            <div>
              <h3 class="font-semibold text-orange-800 mb-1">Perhatian!</h3>
              <p class="text-orange-700 text-sm">Produk-produk ini memiliki engagement score di bawah 5. Pertimbangkan untuk melakukan promosi khusus atau evaluasi kualitas produk.</p>
            </div>
          </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          @forelse($lowProducts as $index => $product)
          <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-orange-200 hover:shadow-xl transition">
            <div class="relative">
              @if($product->gambar)
              <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-full h-64 object-cover opacity-75">
              @else
              <div class="w-full h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                <i class="bi bi-image text-6xl text-gray-400"></i>
              </div>
              @endif

              <!-- Warning Badge -->
              <div class="absolute top-4 left-4 bg-orange-500 text-white px-4 py-2 rounded-full shadow-lg flex items-center gap-2">
                <i class="bi bi-exclamation-triangle"></i>
                <span class="font-semibold">Low Engagement</span>
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
              <div class="bg-gradient-to-r from-orange-400 to-red-500 text-white rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm opacity-90">Engagement Score</p>
                    <p class="text-3xl font-bold">{{ number_format($product->engagement_score) }}</p>
                    <p class="text-xs opacity-75 mt-1">⚠️ Perlu ditingkatkan</p>
                  </div>
                  <i class="bi bi-graph-down-arrow text-4xl opacity-75"></i>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="grid grid-cols-2 gap-3">
                <a href="{{ route('admin.products.show', $product->id) }}" class="text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                  <i class="bi bi-eye"></i> Detail
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition font-semibold">
                  <i class="bi bi-pencil"></i> Edit
                </a>
              </div>
            </div>
          </div>
          @empty
          <div class="col-span-2 text-center py-12 bg-white rounded-xl shadow-lg">
            <i class="bi bi-check-circle text-6xl text-green-500"></i>
            <p class="mt-4 text-gray-700 font-semibold text-lg">Hebat! Semua produk memiliki engagement yang baik</p>
            <p class="text-gray-500 mt-2">Tidak ada produk dengan engagement rendah</p>
          </div>
          @endforelse
        </div>

        <!-- Recommendations -->
        @if($lowProducts->count() > 0)
        <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-8 text-white">
          <h3 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <i class="bi bi-lightbulb-fill"></i>
            Saran Perbaikan
          </h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <h4 class="font-semibold mb-2 flex items-center gap-2">
                <i class="bi bi-megaphone-fill"></i>
                Tingkatkan Promosi
              </h4>
              <p class="text-sm opacity-90">Fokuskan marketing pada produk-produk dengan engagement rendah melalui media sosial dan iklan berbayar</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <h4 class="font-semibold mb-2 flex items-center gap-2">
                <i class="bi bi-image-fill"></i>
                Perbaiki Konten
              </h4>
              <p class="text-sm opacity-90">Update foto produk dengan kualitas lebih baik dan deskripsi yang lebih menarik</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <h4 class="font-semibold mb-2 flex items-center gap-2">
                <i class="bi bi-tag-fill"></i>
                Strategi Harga
              </h4>
              <p class="text-sm opacity-90">Evaluasi pricing dan pertimbangkan diskon khusus untuk meningkatkan minat pembeli</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
              <h4 class="font-semibold mb-2 flex items-center gap-2">
                <i class="bi bi-people-fill"></i>
                Feedback Pelanggan
              </h4>
              <p class="text-sm opacity-90">Kumpulkan feedback untuk memahami alasan kurangnya minat dan lakukan perbaikan</p>
            </div>
          </div>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
          <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <i class="bi bi-exclamation-triangle text-4xl mb-3"></i>
            <h3 class="text-lg font-semibold">Total Produk</h3>
            <p class="text-3xl font-bold mt-2">{{ $lowProducts->count() }}</p>
            <p class="text-orange-100 text-sm mt-1">Perlu perhatian</p>
          </div>

          <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <i class="bi bi-eye-fill text-4xl mb-3"></i>
            <h3 class="text-lg font-semibold">Avg Views</h3>
            <p class="text-3xl font-bold mt-2">{{ $lowProducts->count() > 0 ? number_format($lowProducts->avg('jumlah_view'), 1) : 0 }}</p>
            <p class="text-purple-100 text-sm mt-1">Per produk</p>
          </div>

          <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <i class="bi bi-cart-fill text-4xl mb-3"></i>
            <h3 class="text-lg font-semibold">Avg Clicks</h3>
            <p class="text-3xl font-bold mt-2">{{ $lowProducts->count() > 0 ? number_format($lowProducts->avg('jumlah_klik_beli'), 1) : 0 }}</p>
            <p class="text-green-100 text-sm mt-1">Per produk</p>
          </div>

          <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <i class="bi bi-heart-fill text-4xl mb-3"></i>
            <h3 class="text-lg font-semibold">Avg Likes</h3>
            <p class="text-3xl font-bold mt-2">{{ $lowProducts->count() > 0 ? number_format($lowProducts->avg('jumlah_like'), 1) : 0 }}</p>
            <p class="text-red-100 text-sm mt-1">Per produk</p>
          </div>
        </div>
        @endif

      </div>
    </main>
  </div>
</body>
</html>
