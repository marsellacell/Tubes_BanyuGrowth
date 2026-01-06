<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard UMKM - BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
          <h2 class="text-2xl font-bold text-gray-800">Dashboard UMKM</h2>
          <p class="text-gray-600 mt-1">Selamat datang, <strong>{{ session('umkm_nama') }}</strong></p>
        </div>



        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
              </div>
              <i class="bi bi-box-seam text-4xl text-blue-500"></i>
            </div>
          </div>

          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Produk Aktif</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['active_products'] }}</p>
              </div>
              <i class="bi bi-check-circle text-4xl text-green-500"></i>
            </div>
          </div>

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
                <p class="text-gray-600 text-sm">Klik Beli</p>
                <p class="text-2xl font-bold text-orange-600">{{ number_format($stats['total_clicks']) }}</p>
              </div>
              <i class="bi bi-bag-check text-4xl text-orange-500"></i>
            </div>
          </div>
        </div>

        <!-- Products List -->
        <div class="bg-white rounded-xl shadow-lg p-6">
          <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">
              <i class="bi bi-box-seam text-blue-500"></i> Produk Saya
            </h3>
            <a href="/umkm/products/create" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition font-semibold shadow-md">
              <i class="bi bi-plus-circle mr-2"></i>
              Tambah Produk
            </a>
          </div>

          @if($products->isEmpty())
          <div class="text-center py-12">
            <i class="bi bi-inbox text-gray-300 text-6xl mb-4"></i>
            <p class="text-gray-500 mb-4">Belum ada produk. Mulai tambahkan produk pertama Anda!</p>
            <a href="/umkm/products/create" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-lg">
              <i class="bi bi-plus-circle mr-2"></i>
              Tambah Produk Sekarang
            </a>
          </div>
          @else
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                <tr>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Produk</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Harga</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Views</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Likes</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Clicks</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      @if($product->image && $product->image != '/assets/img/default-product.jpg')
                      <img src="{{ $product->image }}" alt="{{ $product->nama_produk }}" class="w-14 h-14 object-cover rounded-lg shadow">
                      @else
                      <div class="w-14 h-14 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="bi bi-image text-gray-400 text-xl"></i>
                      </div>
                      @endif
                      <div>
                        <div class="font-semibold text-gray-800">{{ $product->nama_produk }}</div>
                        <div class="text-sm text-gray-500">{{ Str::limit($product->deskripsi, 50) }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 font-bold text-green-600">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                  </td>
                  <td class="px-6 py-4">
                    @if($product->status === 'active')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                      <i class="bi bi-check-circle"></i> Aktif
                    </span>
                    @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                      <i class="bi bi-x-circle"></i> Nonaktif
                    </span>
                    @endif
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <i class="bi bi-eye-fill text-purple-500"></i>
                      <span class="font-semibold text-gray-700">{{ number_format($product->jumlah_view) }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <i class="bi bi-heart-fill text-red-500"></i>
                      <span class="font-semibold text-gray-700">{{ number_format($product->jumlah_like ?? 0) }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <i class="bi bi-bag-check-fill text-green-500"></i>
                      <span class="font-semibold text-gray-700">{{ number_format($product->jumlah_klik_beli) }}</span>
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <a href="/umkm/products/{{ $product->id }}/edit" class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition" title="Edit">
                        <i class="bi bi-pencil-square text-lg"></i>
                      </a>
                      <form action="/umkm/products/{{ $product->id }}" method="POST" id="delete-form-{{ $product->id }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete('delete-form-{{ $product->id }}')" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition" title="Hapus">
                          <i class="bi bi-trash text-lg"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @endif
        </div>
      </div>
    </main>
  </div>

</body>
</html>
