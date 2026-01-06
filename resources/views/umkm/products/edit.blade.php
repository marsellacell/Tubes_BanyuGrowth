<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk - BanyuGrowth</title>
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
      <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">
              <i class="bi bi-pencil-square text-orange-500"></i> Edit Produk
            </h2>
            <p class="text-gray-600 mt-1">Perbarui informasi produk Anda</p>
          </div>
          <a href="/umkm/products" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-semibold">
            <i class="bi bi-arrow-left mr-2"></i>
            Kembali
          </a>
        </div>

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

        <div class="bg-white rounded-xl shadow-lg p-8">
          <form action="/umkm/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nama Produk -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-tag"></i> Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
              </div>

              <!-- Kategori -->
              <div>
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-grid"></i> Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                  <option value="">Pilih Kategori</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->nama_kategori }}
                  </option>
                  @endforeach
                </select>
              </div>

              <!-- Harga -->
              <div>
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-currency-dollar"></i> Harga (Rp) <span class="text-red-500">*</span>
                </label>
                <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" required min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
              </div>

              <!-- Lokasi -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-geo-alt"></i> Lokasi/Alamat Usaha
                </label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $product->lokasi) }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
              </div>

              <!-- Deskripsi -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-file-text"></i> Deskripsi Produk <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi" rows="5" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">{{ old('deskripsi', $product->deskripsi) }}</textarea>
              </div>

              <!-- Status -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-toggle-on"></i> Status Produk <span class="text-red-500">*</span>
                </label>
                <select name="status" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                  <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                  <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                <p class="text-sm text-gray-500 mt-2"><i class="bi bi-info-circle"></i> Produk aktif akan ditampilkan di marketplace</p>
              </div>

              <!-- Upload Gambar -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-image"></i> Gambar Produk <span class="text-gray-500 text-sm">(Opsional)</span>
                </label>

                @if($product->gambar)
                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                  <p class="text-sm text-gray-600 mb-2 font-semibold">Gambar Saat Ini:</p>
                  <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}" class="max-h-48 rounded-lg shadow-md">
                </div>
                @endif

                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition">
                  <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(event)">
                  <label for="imageInput" class="cursor-pointer">
                    <div id="imagePreview">
                      <i class="bi bi-cloud-upload text-gray-400 text-5xl"></i>
                      <p class="text-gray-600 mt-2 font-semibold">Klik untuk upload gambar baru</p>
                      <p class="text-sm text-gray-500">Format: JPG, PNG, JPEG (Max: 2MB)</p>
                      <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
                    </div>
                  </label>
                </div>
              </div>
            </div>

            <!-- Product Stats -->
            <div class="mt-8 bg-gradient-to-r from-purple-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
              <h3 class="font-bold text-lg mb-4">
                <i class="bi bi-graph-up-arrow"></i> Statistik Produk
              </h3>
              <div class="grid grid-cols-3 gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                  <i class="bi bi-eye-fill text-3xl mb-2"></i>
                  <p class="text-2xl font-bold">{{ number_format($product->jumlah_view ?? 0) }}</p>
                  <p class="text-sm opacity-90">Total Views</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                  <i class="bi bi-heart-fill text-3xl mb-2"></i>
                  <p class="text-2xl font-bold">{{ number_format($product->jumlah_like ?? 0) }}</p>
                  <p class="text-sm opacity-90">Total Likes</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 text-center">
                  <i class="bi bi-bag-check-fill text-3xl mb-2"></i>
                  <p class="text-2xl font-bold">{{ number_format($product->jumlah_klik_beli ?? 0) }}</p>
                  <p class="text-sm opacity-90">Klik Beli</p>
                </div>
              </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-8">
              <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg transition shadow-lg">
                <i class="bi bi-save mr-2"></i>
                Update Produk
              </button>
              <a href="/umkm/products" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-8 py-3 rounded-lg transition">
                <i class="bi bi-x-circle mr-2"></i>
                Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script>
    function previewImage(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('imagePreview');

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.innerHTML = `
                        <img src="${e.target.result}" class="max-h-64 mx-auto rounded-lg shadow-md mb-2">
                        <p class="text-sm text-gray-600">${file.name}</p>
                    `;
        }
        reader.readAsDataURL(file);
      }
    }

  </script>

</body>
</html>
