<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Informasi - Admin Panel</title>
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
      <div class="max-w-4xl mx-auto">
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">
            <i class="bi bi-pencil-square text-blue-500"></i> Edit Informasi
          </h2>
          <p class="text-gray-600 mt-1">Perbarui informasi yang sudah ada</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-8">
          <form action="{{ route('admin.information.update', $information->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Judul -->
            <div class="mb-6">
              <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
                <i class="bi bi-card-heading text-blue-600"></i>
                Judul Informasi <span class="text-red-500">*</span>
              </label>
              <input type="text" name="judul" value="{{ old('judul', $information->judul) }}" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Masukkan judul informasi">
              @error('judul')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Banner Upload -->
            <div class="mb-6">
              <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
                <i class="bi bi-image text-green-600"></i>
                Banner Informasi
              </label>
              
              <!-- Current Banner -->
              @if($information->banner)
              <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">Banner saat ini:</p>
                <img src="{{ Storage::url($information->banner) }}" alt="Current Banner" class="w-full h-64 object-cover rounded-lg shadow-lg">
              </div>
              @endif

              <input type="file" name="banner" id="banner" accept="image/*" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
              <p class="text-xs text-gray-500 mt-2">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah banner.</p>
              @error('banner')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
              
              <!-- Preview -->
              <div id="bannerPreview" class="mt-4 hidden">
                <p class="text-sm text-gray-600 mb-2">Preview banner baru:</p>
                <img id="previewImage" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg shadow-lg">
              </div>
            </div>

            <!-- Konten -->
            <div class="mb-6">
              <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
                <i class="bi bi-file-text text-purple-600"></i>
                Konten Informasi <span class="text-red-500">*</span>
              </label>
              <textarea name="konten" rows="10" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Tulis konten informasi secara lengkap...">{{ old('konten', $information->konten) }}</textarea>
              @error('konten')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Publish Status -->
            <div class="mb-6">
              <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $information->is_published) ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-gray-700 font-semibold">
                  <i class="bi bi-eye text-blue-600"></i> Publish
                </span>
              </label>
              <p class="text-xs text-gray-500 mt-2 ml-8">Jika tidak dicentang, informasi akan disimpan sebagai draft</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-4">
              <a href="{{ route('admin.information.index') }}" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                <i class="bi bi-x-circle"></i> Batal
              </a>
              <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition shadow-lg">
                <i class="bi bi-check-circle"></i> Update Informasi
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Preview banner image
    document.getElementById('banner').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('previewImage').src = e.target.result;
          document.getElementById('bannerPreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>
