<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile - BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    #imagePreview {
      display: none;
    }

  </style>
</head>
<body class="bg-gray-50">
  @include('components.sweetalert')

  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.umkm-sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8 pt-20 lg:pt-8">
      <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
          <div class="flex items-center gap-3 mb-2">
            <i class="bi bi-person-circle text-3xl text-blue-600"></i>
            <h2 class="text-2xl font-bold text-gray-800">Edit Profile</h2>
          </div>
          <p class="text-gray-600">Perbarui informasi profil UMKM Anda</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
          <div class="flex items-center gap-2">
            <i class="bi bi-check-circle text-green-500"></i>
            <p class="text-green-700 font-semibold">{{ session('success') }}</p>
          </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
          <div class="flex items-center gap-2">
            <i class="bi bi-exclamation-circle text-red-500"></i>
            <p class="text-red-700 font-semibold">{{ session('error') }}</p>
          </div>
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
          <form action="{{ route('umkm.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Logo UMKM -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-image text-purple-600"></i> Logo UMKM
              </label>

              @if($umkm->logo_umkm)
              <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-600 mb-2">Logo saat ini:</p>
                <img src="{{ Storage::url($umkm->logo_umkm) }}" alt="Logo" class="w-32 h-32 object-cover rounded-lg shadow-md">
              </div>
              @endif

              <!-- Preview Image -->
              <div id="imagePreview" class="mb-4 p-4 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-600 mb-2 font-semibold">Preview logo baru:</p>
                <img id="previewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded-lg shadow-md">
              </div>

              <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-green-500 transition" id="uploadArea">
                <input type="file" name="logo_umkm" id="logo_umkm" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                <div class="text-center">
                  <i class="bi bi-cloud-upload text-4xl text-gray-400 mb-2"></i>
                  <p class="text-gray-600">Klik untuk upload logo baru</p>
                  <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (Max: 2MB)</p>
                </div>
              </div>
              @error('logo_umkm')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Username (Read Only) -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-person-badge text-gray-600"></i> Username
              </label>
              <input type="text" value="{{ $umkm->username }}" readonly class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 cursor-not-allowed">
              <p class="text-sm text-gray-500 mt-1">Username tidak dapat diubah</p>
            </div>

            <!-- Nama Lengkap -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-person text-blue-600"></i> Nama Lengkap <span class="text-red-500">*</span>
              </label>
              <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $umkm->nama_lengkap) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
              @error('nama_lengkap')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Nama Usaha -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-shop text-green-600"></i> Nama Usaha <span class="text-red-500">*</span>
              </label>
              <input type="text" name="nama_usaha" value="{{ old('nama_usaha', $umkm->nama_usaha) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
              @error('nama_usaha')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-envelope text-orange-600"></i> Email <span class="text-red-500">*</span>
              </label>
              <input type="email" name="email" value="{{ old('email', $umkm->email) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
              @error('email')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- No Telepon -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-telephone text-teal-600"></i> No Telepon <span class="text-red-500">*</span>
              </label>
              <input type="text" name="no_telepon" value="{{ old('no_telepon', $umkm->no_telepon) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
              @error('no_telepon')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-8"></div>

            <!-- Password Section -->
            <div class="bg-blue-50 p-4 rounded-lg mb-6">
              <p class="text-sm text-blue-700 font-semibold mb-1">
                <i class="bi bi-info-circle"></i> Ubah Password (Opsional)
              </p>
              <p class="text-sm text-blue-600">Kosongkan jika tidak ingin mengubah password</p>
            </div>

            <!-- Password Baru -->
            <div class="mb-6">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-key text-red-600"></i> Password Baru
              </label>
              <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan password baru (minimal 6 karakter)">
              @error('password')
              <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-8">
              <label class="block text-gray-700 font-semibold mb-2">
                <i class="bi bi-key text-red-600"></i> Konfirmasi Password Baru
              </label>
              <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Konfirmasi password baru">
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4">
              <button type="submit" class="flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition shadow-lg">
                <i class="bi bi-check-circle"></i>
                <span>Simpan Perubahan</span>
              </button>
              <a href="/umkm/dashboard" class="flex items-center gap-2 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                <i class="bi bi-x-circle"></i>
                <span>Batal</span>
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
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('previewImg').src = e.target.result;
          document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
      }
    }

  </script>

</body>
</html>
