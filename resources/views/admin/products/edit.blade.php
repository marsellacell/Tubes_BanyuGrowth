<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk | Admin BanyuGrowth</title>
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
      <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">
              <i class="bi bi-pencil-square text-orange-500"></i> Edit Produk
            </h2>
            <p class="text-gray-600 mt-1">Perbarui informasi produk</p>
          </div>
          <a href="{{ route('admin.products.show', $product->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
          <div class="flex items-center gap-2">
            <i class="bi bi-check-circle text-green-500"></i>
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
          </div>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
          <div class="flex items-start gap-2">
            <i class="bi bi-exclamation-triangle text-red-500 mt-1"></i>
            <div>
              <p class="text-red-700 font-semibold mb-2">Terdapat kesalahan:</p>
              <ul class="list-disc list-inside text-red-600 text-sm">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
          <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-tag"></i> Nama Produk
              </label>
              <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan nama produk" required>
            </div>

            <!-- Description -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-file-text"></i> Deskripsi
              </label>
              <textarea name="deskripsi" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan deskripsi produk" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
            </div>

            <!-- Price & Stock -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
              <div>
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-currency-dollar"></i> Harga (Rp)
                </label>
                <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="0" min="0" required>
              </div>

              <div>
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-box"></i> Stok
                </label>
                <input type="number" name="stok" value="{{ old('stok', $product->stok) }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="0" min="0" required>
              </div>
            </div>

            <!-- Category -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-grid"></i> Kategori
              </label>
              <select name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                  {{ $category->nama_kategori }}
                </option>
                @endforeach
              </select>
            </div>

            <!-- Current Image -->
            @if($product->gambar)
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-image"></i> Gambar Saat Ini
              </label>
              <div class="border border-gray-300 rounded-lg p-4 inline-block">
                <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="h-48 rounded-lg">
              </div>
            </div>
            @endif

            <!-- New Image Upload -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-upload"></i> Upload Gambar Baru (Opsional)
              </label>
              <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
              <p class="text-sm text-gray-500 mt-2">
                <i class="bi bi-info-circle"></i> Format: JPG, JPEG, PNG. Maksimal 2MB
              </p>
            </div>

            <!-- UMKM Info (Read Only) -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-shop"></i> Pemilik UMKM
              </label>
              <p class="text-gray-800 font-semibold">{{ $product->umkm->nama_usaha }}</p>
              <p class="text-sm text-gray-600">{{ $product->umkm->email }}</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
              <button type="submit" class="flex-1 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold shadow-lg">
                <i class="bi bi-save"></i> Simpan Perubahan
              </button>
              <a href="{{ route('admin.products.show', $product->id) }}" class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-semibold">
                <i class="bi bi-x-circle"></i> Batal
              </a>
            </div>
          </form>
        </div>

        <!-- Engagement Statistics -->
        <div class="mt-8 bg-gradient-to-r from-purple-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
          <h3 class="font-bold text-xl mb-4">
            <i class="bi bi-graph-up-arrow"></i> Statistik Engagement
          </h3>
          <div class="grid grid-cols-3 gap-4">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
              <i class="bi bi-eye-fill text-3xl mb-2"></i>
              <p class="text-2xl font-bold">{{ number_format($product->jumlah_view ?? 0) }}</p>
              <p class="text-sm opacity-90">Total Views</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
              <i class="bi bi-cart-fill text-3xl mb-2"></i>
              <p class="text-2xl font-bold">{{ number_format($product->jumlah_klik_beli ?? 0) }}</p>
              <p class="text-sm opacity-90">Total Clicks</p>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
              <i class="bi bi-heart-fill text-3xl mb-2"></i>
              <p class="text-2xl font-bold">{{ number_format($product->jumlah_like ?? 0) }}</p>
              <p class="text-sm opacity-90">Total Likes</p>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>
</body>
</html>
