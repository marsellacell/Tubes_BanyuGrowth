<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk - BanyuGrowth</title>
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
              <i class="bi bi-plus-circle text-green-500"></i> Tambah Produk Baru
            </h2>
            <p class="text-gray-600 mt-1">Isi form di bawah untuk menambahkan produk baru</p>
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
          <form action="/umkm/products" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Nama Produk -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-tag"></i> Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: Kue Brownies Premium">
              </div>

              <!-- Kategori -->
              <div>
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-grid"></i> Kategori <span class="text-red-500">*</span>
                </label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                  <option value="">Pilih Kategori</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="50000">
              </div>

              <!-- Lokasi -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-geo-alt"></i> Lokasi/Alamat Usaha
                </label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Contoh: Purwokerto Selatan">
              </div>

              <!-- Deskripsi -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-file-text"></i> Deskripsi Produk <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi" rows="5" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Jelaskan detail produk Anda...">{{ old('deskripsi') }}</textarea>
              </div>

              <!-- Upload Gambar -->
              <div class="md:col-span-2">
                <label class="block text-gray-700 font-semibold mb-2">
                  <i class="bi bi-image"></i> Gambar Produk <span class="text-gray-500 text-sm">(Opsional)</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition">
                  <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(event)">
                  <label for="imageInput" class="cursor-pointer">
                    <div id="imagePreview">
                      <i class="bi bi-cloud-upload text-gray-400 text-5xl"></i>
                      <p class="text-gray-600 mt-2 font-semibold">Klik untuk upload gambar</p>
                      <p class="text-sm text-gray-500">Format: JPG, PNG, JPEG (Max: 2MB)</p>
                      <p class="text-xs text-gray-400 mt-1">Jika tidak diupload, akan menggunakan gambar default</p>
                    </div>
                  </label>
                </div>
              </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 mt-8">
              <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-8 py-3 rounded-lg transition shadow-lg">
                <i class="bi bi-check-circle mr-2"></i>
                Simpan Produk
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
