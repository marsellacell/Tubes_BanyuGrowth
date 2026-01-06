<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Produk | Admin BanyuGrowth</title>
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
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">Kelola Produk</h2>
          <p class="text-gray-600 mt-1">Daftar semua produk dari seluruh UMKM</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
          {{ session('success') }}
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Produk</p>
                <p class="text-2xl font-bold text-gray-800">{{ $products->count() }}</p>
              </div>
              <i class="bi bi-box-seam text-4xl text-blue-500"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Produk Aktif</p>
                <p class="text-2xl font-bold text-gray-800">{{ $products->where('status', 'active')->count() }}</p>
              </div>
              <i class="bi bi-check-circle text-4xl text-green-500"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Views</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($products->sum('jumlah_view')) }}</p>
              </div>
              <i class="bi bi-eye text-4xl text-purple-500"></i>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="text-gray-600 text-sm">Total Clicks</p>
                <p class="text-2xl font-bold text-gray-800">{{ number_format($products->sum('jumlah_klik_beli')) }}</p>
              </div>
              <i class="bi bi-hand-thumbs-up text-4xl text-orange-500"></i>
            </div>
          </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gray-50 border-b">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UMKM</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                      <img src="{{ $product->image ?? '/assets/img/default-product.jpg' }}" alt="{{ $product->nama_produk }}" class="w-12 h-12 object-cover rounded">
                      <div>
                        <p class="font-semibold text-gray-800">{{ $product->nama_produk }}</p>
                        <p class="text-xs text-gray-500">{{ Str::limit($product->deskripsi, 40) }}</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $product->umkm->nama_usaha ?? 'N/A' }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-700">
                    {{ $product->category->nama_kategori ?? 'N/A' }}
                  </td>
                  <td class="px-6 py-4 text-sm font-semibold text-gray-800">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $product->jumlah_view }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-600">
                    {{ $product->jumlah_klik_beli }}
                  </td>
                  <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                      {{ ucfirst($product->status) }}
                    </span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                      <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-800">
                        <i class="bi bi-eye"></i>
                      </a>
                      <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" id="delete-form-{{ $product->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete('delete-form-{{ $product->id }}')" class="text-red-600 hover:text-red-800">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="px-6 py-12 text-center">
                    <i class="bi bi-inbox text-6xl text-gray-300"></i>
                    <p class="text-gray-500 mt-4">Belum ada produk</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
