<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UMKM Terlaris | Admin BanyuGrowth</title>
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
              <i class="bi bi-trophy text-blue-500"></i> UMKM Terlaris
            </h2>
            <p class="text-gray-600 mt-1">10 UMKM dengan performa terbaik berdasarkan total views produk</p>
          </div>
          <a href="{{ route('admin.statistics.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

        <!-- UMKM List -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <tr>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Ranking</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Nama UMKM</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Pemilik</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Jumlah Produk</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Total Views</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Total Likes</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @forelse($topUmkm as $index => $umkm)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      @if($index < 3) <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white
                        {{ $index === 0 ? 'bg-yellow-500' : ($index === 1 ? 'bg-gray-400' : 'bg-orange-600') }}">
                        {{ $index + 1 }}
                    </div>
                    @else
                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">
                      {{ $index + 1 }}
                    </div>
                    @endif
          </div>
          </td>
          <td class="px-6 py-4">
            <div class="font-semibold text-gray-800">{{ $umkm->nama_usaha }}</div>
            <div class="text-sm text-gray-500">{{ $umkm->email }}</div>
          </td>
          <td class="px-6 py-4 text-gray-700">{{ $umkm->nama_lengkap }}</td>
          <td class="px-6 py-4">
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
              {{ $umkm->products_count }} produk
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <i class="bi bi-eye text-purple-500"></i>
              <span class="font-bold text-gray-800">{{ number_format($umkm->total_views ?? 0) }}</span>
            </div>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <i class="bi bi-heart-fill text-red-500"></i>
              <span class="font-bold text-gray-800">{{ number_format($umkm->total_likes ?? 0) }}</span>
            </div>
          </td>
          <td class="px-6 py-4">
            <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
              <i class="bi bi-eye"></i> Detail
            </a>
          </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
              <i class="bi bi-inbox text-6xl text-gray-300"></i>
              <p class="mt-4">Belum ada data UMKM</p>
            </td>
          </tr>
          @endforelse
          </tbody>
          </table>
        </div>
      </div>

      <!-- Summary Cards -->
      @if($topUmkm->count() > 0)
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-trophy text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">UMKM Teratas</h3>
          <p class="text-2xl font-bold mt-2">{{ $topUmkm->first()->nama_usaha }}</p>
          <p class="text-blue-100 text-sm mt-1">{{ number_format($topUmkm->first()->total_views ?? 0) }} total views</p>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-graph-up-arrow text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">Total Views</h3>
          <p class="text-2xl font-bold mt-2">{{ number_format($topUmkm->sum('total_views')) }}</p>
          <p class="text-green-100 text-sm mt-1">Dari top 10 UMKM</p>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
          <i class="bi bi-heart-fill text-4xl mb-3"></i>
          <h3 class="text-lg font-semibold">Total Likes</h3>
          <p class="text-2xl font-bold mt-2">{{ number_format($topUmkm->sum('total_likes')) }}</p>
          <p class="text-purple-100 text-sm mt-1">Dari top 10 UMKM</p>
        </div>
      </div>
      @endif

  </div>
  </main>
  </div>
</body>
</html>
