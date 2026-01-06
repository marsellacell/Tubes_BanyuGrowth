<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistik | Admin BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50">
  @include('components.sweetalert')
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.admin-sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8 pt-20 lg:pt-8 overflow-y-auto">
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Statistik & Laporan</h2>
          <p class="text-gray-600 mt-1">Overview statistik platform BanyuGrowth</p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
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
                <p class="text-gray-600 text-sm">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
              </div>
              <i class="bi bi-box-seam text-4xl text-green-500"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Views</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_views']) }}</p>
              </div>
              <i class="bi bi-eye text-4xl text-purple-500"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Clicks</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['total_clicks']) }}</p>
              </div>
              <i class="bi bi-hand-thumbs-up text-4xl text-orange-500"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Registrasi Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['monthly_registrations'] }}</p>
              </div>
              <i class="bi bi-person-plus text-4xl text-teal-500"></i>
            </div>
          </div>
        </div>

        <!-- Top Tables Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <!-- UMKM Terlaris -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-bold text-gray-800"><i class="bi bi-trophy text-blue-500"></i> UMKM Terlaris</h3>
              <a href="{{ route('admin.statistics.top-umkm') }}" class="text-blue-600 hover:text-blue-700 text-sm">Lihat Semua</a>
            </div>
            <div class="space-y-3">
              @forelse($topUmkm as $index => $umkm)
              <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                  {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-gray-800 truncate">{{ $umkm->nama_usaha }}</p>
                  <p class="text-xs text-gray-500">{{ $umkm->total_views ?? 0 }} views</p>
                </div>
              </div>
              @empty
              <p class="text-gray-500 text-center py-4">Belum ada data</p>
              @endforelse
            </div>
          </div>

          <!-- Produk Terlaris -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-bold text-gray-800"><i class="bi bi-star text-green-500"></i> Produk Terlaris</h3>
              <a href="{{ route('admin.statistics.top-products') }}" class="text-green-600 hover:text-green-700 text-sm">Lihat Semua</a>
            </div>
            <div class="space-y-3">
              @forelse($topProducts as $index => $product)
              <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                  {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-gray-800 truncate">{{ $product->nama_produk }}</p>
                  <p class="text-xs text-gray-500">{{ $product->engagement_score ?? 0 }} engagement</p>
                </div>
              </div>
              @empty
              <p class="text-gray-500 text-center py-4">Belum ada data</p>
              @endforelse
            </div>
          </div>

          <!-- Produk Kurang Diminati -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-bold text-gray-800"><i class="bi bi-graph-down text-orange-500"></i> Produk Kurang Diminati</h3>
              <a href="{{ route('admin.statistics.low-products') }}" class="text-orange-600 hover:text-orange-700 text-sm">Lihat Semua</a>
            </div>
            <div class="space-y-3">
              @forelse($lowProducts as $index => $product)
              <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                <div class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center font-bold text-sm">
                  {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-gray-800 truncate">{{ $product->nama_produk }}</p>
                  <p class="text-xs text-gray-500">{{ ($product->jumlah_view + $product->jumlah_klik_beli + $product->jumlah_like) }} engagement</p>
                </div>
              </div>
              @empty
              <p class="text-gray-500 text-center py-4">Belum ada data</p>
              @endforelse
            </div>
          </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
          <!-- Pertumbuhan UMKM Chart (Bar Chart) -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
              <i class="bi bi-bar-chart text-indigo-500"></i> Pertumbuhan UMKM per Tahun
            </h3>
            <canvas id="umkmGrowthChart"></canvas>
          </div>

          <!-- Kategori UMKM Chart (Pie Chart) -->
          <div class="bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">
              <i class="bi bi-pie-chart text-pink-500"></i> Distribusi Kategori UMKM
            </h3>
            <canvas id="categoryChart"></canvas>
          </div>
        </div>

      </div>
    </main>
  </div>

  <script>
    // Pertumbuhan UMKM Bar Chart
    const umkmGrowthData = @json($umkmGrowth);
    const umkmGrowthCtx = document.getElementById('umkmGrowthChart').getContext('2d');
    new Chart(umkmGrowthCtx, {
      type: 'bar'
      , data: {
        labels: umkmGrowthData.map(item => item.year)
        , datasets: [{
          label: 'Jumlah UMKM Terdaftar'
          , data: umkmGrowthData.map(item => item.count)
          , backgroundColor: 'rgba(34, 197, 94, 0.7)'
          , borderColor: 'rgba(34, 197, 94, 1)'
          , borderWidth: 2
          , borderRadius: 8
        , }]
      }
      , options: {
        responsive: true
        , maintainAspectRatio: true
        , plugins: {
          legend: {
            display: true
            , position: 'top'
          , }
          , tooltip: {
            callbacks: {
              label: function(context) {
                return 'Jumlah: ' + context.parsed.y + ' UMKM';
              }
            }
          }
        }
        , scales: {
          y: {
            beginAtZero: true
            , ticks: {
              stepSize: 1
            }
          }
        }
      }
    });

    // Kategori UMKM Pie Chart
    const categoryData = @json($umkmByCategory);
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
      type: 'pie'
      , data: {
        labels: categoryData.map(item => item.category)
        , datasets: [{
          data: categoryData.map(item => item.count)
          , backgroundColor: [
            'rgba(59, 130, 246, 0.7)', // Blue
            'rgba(34, 197, 94, 0.7)', // Green
            'rgba(251, 146, 60, 0.7)', // Orange
            'rgba(168, 85, 247, 0.7)', // Purple
            'rgba(236, 72, 153, 0.7)', // Pink
            'rgba(14, 165, 233, 0.7)', // Sky
            'rgba(234, 179, 8, 0.7)', // Yellow
            'rgba(239, 68, 68, 0.7)', // Red
          ]
          , borderColor: 'white'
          , borderWidth: 2
        , }]
      }
      , options: {
        responsive: true
        , maintainAspectRatio: true
        , plugins: {
          legend: {
            position: 'right'
            , labels: {
              padding: 15
              , font: {
                size: 11
              }
            }
          }
          , tooltip: {
            callbacks: {
              label: function(context) {
                const label = context.label || '';
                const value = context.parsed || 0;
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const percentage = ((value / total) * 100).toFixed(1);
                return label + ': ' + value + ' UMKM (' + percentage + '%)';
              }
            }
          }
        }
      }
    });

  </script>
</body>
</html>
