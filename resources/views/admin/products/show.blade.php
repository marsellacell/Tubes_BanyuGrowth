<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Produk | Admin BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
      <div class="p-6">
        <div class="flex items-center gap-2 mb-8">
          <i class="bi bi-shield-check text-3xl text-green-600"></i>
          <h1 class="font-bold text-xl text-gray-800">Admin Panel</h1>
        </div>

        <nav class="space-y-2">
          <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
          </a>
          <a href="{{ route('admin.umkm.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
            <i class="bi bi-shop"></i>
            <span>Kelola UMKM</span>
          </a>
          <a href="{{ route('admin.umkm.pending') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
            <i class="bi bi-hourglass-split"></i>
            <span>UMKM Pending</span>
          </a>
          <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
            <i class="bi bi-box-seam"></i>
            <span>Kelola Produk</span>
          </a>
          <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
            <i class="bi bi-graph-up"></i>
            <span>Statistik</span>
          </a>
          <a href="{{ route('admin.logout') }}" class="flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg mt-8">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
          </a>
        </nav>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 pt-20 lg:pt-8">
      <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Produk</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap produk</p>
          </div>
          <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

        <!-- Product Detail Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
              <img src="{{ $product->image ?? '/assets/img/default-product.jpg' }}" alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-8">
              <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $product->nama_produk }}</h3>

              <div class="space-y-3 mb-6">
                <div class="flex items-center gap-2">
                  <i class="bi bi-shop text-gray-500"></i>
                  <span class="text-gray-700">
                    UMKM: <strong>{{ $product->umkm->nama_usaha ?? 'N/A' }}</strong>
                  </span>
                </div>
                <div class="flex items-center gap-2">
                  <i class="bi bi-tag text-gray-500"></i>
                  <span class="text-gray-700">
                    Kategori: <strong>{{ $product->category->nama_kategori ?? 'N/A' }}</strong>
                  </span>
                </div>
                @if($product->lokasi)
                <div class="flex items-center gap-2">
                  <i class="bi bi-geo-alt text-gray-500"></i>
                  <span class="text-gray-700">{{ $product->lokasi }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2">
                  <i class="bi bi-calendar text-gray-500"></i>
                  <span class="text-gray-700">
                    Dibuat: {{ $product->created_at->format('d M Y') }}
                  </span>
                </div>
              </div>

              <div class="mb-6">
                <h4 class="font-semibold text-gray-700 mb-2">Deskripsi</h4>
                <p class="text-gray-600 leading-relaxed">{{ $product->deskripsi }}</p>
              </div>

              <div class="flex items-center gap-2 mb-6">
                <span class="px-3 py-1 rounded-full text-sm {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                  {{ ucfirst($product->status) }}
                </span>
              </div>

              <div class="border-t pt-6">
                <p class="text-3xl font-bold text-green-600 mb-4">
                  Rp {{ number_format($product->harga, 0, ',', '.') }}
                </p>

                <div class="grid grid-cols-2 gap-4 mb-6">
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Views</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $product->jumlah_view }}</p>
                  </div>
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600">Total Clicks</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $product->jumlah_klik_beli }}</p>
                  </div>
                </div>

                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <i class="bi bi-trash"></i> Hapus Produk
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- UMKM Contact Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
          <h4 class="font-semibold text-gray-800 mb-4"><i class="bi bi-telephone"></i> Informasi Kontak UMKM</h4>
          <div class="space-y-2">
            <p class="text-gray-700"><i class="bi bi-person"></i> {{ $product->umkm->nama_lengkap ?? 'N/A' }}</p>
            <p class="text-gray-700"><i class="bi bi-envelope"></i> {{ $product->umkm->email ?? 'N/A' }}</p>
            <p class="text-gray-700"><i class="bi bi-telephone"></i> {{ $product->umkm->no_telepon ?? 'N/A' }}</p>
            @if($product->umkm->alamat)
            <p class="text-gray-700"><i class="bi bi-geo-alt"></i> {{ $product->umkm->alamat }}</p>
            @endif
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
