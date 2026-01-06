<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistik UMKM - BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
  @include('components.sweetalert')

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.umkm-sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8 pt-20 lg:pt-8">
      <div class="max-w-7xl mx-auto">
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">
            <i class="bi bi-graph-up text-purple-500"></i> Statistik & Analisis
          </h2>
          <p class="text-gray-600 mt-1">Monitor performa produk dan engagement pelanggan</p>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Views</p>
                <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_views']) }}</p>
              </div>
              <i class="bi bi-eye text-4xl text-purple-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Likes</p>
                <p class="text-2xl font-bold text-red-600">{{ number_format($stats['total_likes']) }}</p>
              </div>
              <i class="bi bi-heart-fill text-4xl text-red-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Klik Beli</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_clicks']) }}</p>
              </div>
              <i class="bi bi-bag-check text-4xl text-green-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Engagement Rate</p>
                <p class="text-2xl font-bold text-orange-600">
                  {{ $stats['total_views'] > 0 ? number_format(($stats['total_clicks'] / $stats['total_views']) * 100, 1) : 0 }}%
                </p>
              </div>
              <i class="bi bi-graph-up-arrow text-4xl text-orange-500"></i>
            </div>
          </div>
        </div>

        <!-- Top Products Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
          <div class="p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800">
              <i class="bi bi-star-fill text-yellow-500"></i> Top 5 Produk Terpopuler
            </h3>
            <p class="text-sm text-gray-600 mt-1">Produk dengan views tertinggi</p>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                <tr>
                  <th class="px-6 py-4 text-left text-sm font-semibold">RANKING</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">PRODUK</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">VIEWS</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">LIKES</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">KLIK BELI</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">ENGAGEMENT</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @forelse($stats['top_products'] as $index => $product)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-4">
                    @if($index < 3) <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-lg
                      {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-600') }}">
                      {{ $index + 1 }}
          </div>
          @else
          <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center font-bold text-lg">
            {{ $index + 1 }}
          </div>
          @endif
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-3">
              @if($product->gambar)
              <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="w-14 h-14 object-cover rounded-lg shadow">
              @else
              <div class="w-14 h-14 bg-gray-200 rounded-lg flex items-center justify-center">
                <i class="bi bi-image text-gray-400 text-xl"></i>
              </div>
              @endif
              <div>
                <div class="font-semibold text-gray-800">{{ $product->nama_produk }}</div>
                <div class="text-sm text-green-600 font-semibold">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
              </div>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <i class="bi bi-eye-fill text-purple-500"></i>
              <span class="font-bold text-gray-800">{{ number_format($product->jumlah_view) }}</span>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <i class="bi bi-heart-fill text-red-500"></i>
              <span class="font-bold text-gray-800">{{ number_format($product->jumlah_like ?? 0) }}</span>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <i class="bi bi-bag-check-fill text-green-500"></i>
              <span class="font-bold text-gray-800">{{ number_format($product->jumlah_klik_beli) }}</span>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="bg-gradient-to-r from-purple-500 to-blue-600 text-white px-4 py-2 rounded-full text-center font-bold">
              {{ number_format($product->jumlah_view + $product->jumlah_klik_beli + ($product->jumlah_like ?? 0)) }}
            </div>
          </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
              <i class="bi bi-inbox text-6xl text-gray-300"></i>
              <p class="mt-4">Belum ada data statistik produk</p>
            </td>
          </tr>
          @endforelse
          </tbody>
          </table>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Product Performance Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            <i class="bi bi-bar-chart-fill text-blue-500"></i> Performa Produk
          </h3>
          <canvas id="productChart"></canvas>
        </div>

        <!-- Engagement Breakdown -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            <i class="bi bi-pie-chart-fill text-green-500"></i> Breakdown Engagement
          </h3>
          <canvas id="engagementChart"></canvas>
        </div>
      </div>

      <!-- Tips Section -->
      <div class="mt-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg p-8 text-white">
        <h3 class="text-2xl font-bold mb-4 flex items-center gap-2">
          <i class="bi bi-lightbulb-fill"></i>
          Tips Meningkatkan Performa
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
            <h4 class="font-semibold mb-2 flex items-center gap-2">
              <i class="bi bi-camera-fill"></i>
              Foto Berkualitas
            </h4>
            <p class="text-sm opacity-90">Gunakan foto produk yang jelas dan menarik untuk meningkatkan views</p>
          </div>
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
            <h4 class="font-semibold mb-2 flex items-center gap-2">
              <i class="bi bi-file-text-fill"></i>
              Deskripsi Lengkap
            </h4>
            <p class="text-sm opacity-90">Tulis deskripsi produk yang detail dan informatif</p>
          </div>
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
            <h4 class="font-semibold mb-2 flex items-center gap-2">
              <i class="bi bi-tag-fill"></i>
              Harga Kompetitif
            </h4>
            <p class="text-sm opacity-90">Pastikan harga produk Anda kompetitif di pasaran</p>
          </div>
          <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
            <h4 class="font-semibold mb-2 flex items-center gap-2">
              <i class="bi bi-arrow-clockwise"></i>
              Update Berkala
            </h4>
            <p class="text-sm opacity-90">Perbarui produk dan tambahkan produk baru secara rutin</p>
          </div>
        </div>
      </div>

  </div>
  </main>
  </div>

  <script>
    // Product Performance Bar Chart
    const productCtx = document.getElementById('productChart');
    if (productCtx) {
      const ctx = productCtx.getContext('2d');
      const productData = @json($stats['top_products']->values());

      console.log('Product Data:', productData);

      if (productData && productData.length > 0) {
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: productData.map(p => p.nama_produk ? p.nama_produk.substring(0, 20) : 'N/A'),
            datasets: [{
              label: 'Views',
              data: productData.map(p => parseInt(p.jumlah_view) || 0),
              backgroundColor: 'rgba(168, 85, 247, 0.8)',
              borderColor: 'rgba(168, 85, 247, 1)',
              borderWidth: 2
            }, {
              label: 'Likes',
              data: productData.map(p => parseInt(p.jumlah_like) || 0),
              backgroundColor: 'rgba(239, 68, 68, 0.8)',
              borderColor: 'rgba(239, 68, 68, 1)',
              borderWidth: 2
            }, {
              label: 'Klik Beli',
              data: productData.map(p => parseInt(p.jumlah_klik_beli) || 0),
              backgroundColor: 'rgba(34, 197, 94, 0.8)',
              borderColor: 'rgba(34, 197, 94, 1)',
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                position: 'top',
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      } else {
        productCtx.parentElement.innerHTML = '<div class="text-center py-8 text-gray-500"><i class="bi bi-inbox text-5xl"></i><p class="mt-2">Belum ada data produk</p></div>';
      }
    }

    // Engagement Pie Chart
    const engagementCtx = document.getElementById('engagementChart');
    if (engagementCtx) {
      const ctx2 = engagementCtx.getContext('2d');
      const totalViews = {{ $stats['total_views'] ?? 0 }};
      const totalLikes = {{ $stats['total_likes'] ?? 0 }};
      const totalClicks = {{ $stats['total_clicks'] ?? 0 }};

      if (totalViews > 0 || totalLikes > 0 || totalClicks > 0) {
        new Chart(ctx2, {
          type: 'doughnut',
          data: {
            labels: ['Views', 'Likes', 'Klik Beli'],
            datasets: [{
              data: [totalViews, totalLikes, totalClicks],
              backgroundColor: [
                'rgba(168, 85, 247, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(34, 197, 94, 0.8)'
              ],
              borderColor: [
                'rgba(168, 85, 247, 1)',
                'rgba(239, 68, 68, 1)',
                'rgba(34, 197, 94, 1)'
              ],
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                position: 'bottom',
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                    return context.label + ': ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });
      } else {
        engagementCtx.parentElement.innerHTML = '<div class="text-center py-8 text-gray-500"><i class="bi bi-inbox text-5xl"></i><p class="mt-2">Belum ada data engagement</p></div>';
      }
    }
  </script>

</body>
</html>
