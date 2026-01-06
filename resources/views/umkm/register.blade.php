<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register UMKM - BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      position: relative;
      background: linear-gradient(to top, #4095BA 0%, #7BD87D 100%);
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url('/assets/bg/image.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0.35;
      z-index: 0;
      pointer-events: none;
    }

    body>* {
      position: relative;
      z-index: 1;
    }

    .step {
      display: none;
    }

    .step.active {
      display: block;
    }

  </style>
</head>
<body class="min-h-screen flex items-center justify-center py-12 px-4">
  @include('components.sweetalert')

  <div class="w-full max-w-xl">
    <!-- Header Card -->
    <div class="bg-white rounded-t-2xl shadow-2xl p-8 text-center">
      <div class="flex justify-center mb-4">
        <div class="bg-gradient-to-br from-green-400 to-blue-500 p-4 rounded-full">
          <i class="bi bi-shop-window text-4xl text-white"></i>
        </div>
      </div>
      <h2 class="text-3xl font-bold text-gray-800 mb-2">Daftar UMKM</h2>
      <p class="text-gray-600">Bergabunglah dengan BanyuGrowth dan kembangkan bisnis Anda</p>

      <!-- Progress Indicator -->
      <div class="flex items-center justify-center gap-4 mt-6">
        <div class="flex items-center gap-2">
          <div id="step1-indicator" class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">
            1
          </div>
          <span id="step1-text" class="text-sm font-semibold text-green-600">Data Pribadi</span>
        </div>
        <div class="w-12 h-1 bg-gray-300" id="progress-line"></div>
        <div class="flex items-center gap-2">
          <div id="step2-indicator" class="w-10 h-10 rounded-full bg-gray-300 text-gray-500 flex items-center justify-center font-bold">
            2
          </div>
          <span id="step2-text" class="text-sm font-semibold text-gray-400">Data Usaha</span>
        </div>
      </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-b-2xl shadow-2xl p-8">
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
          <i class="bi bi-exclamation-circle text-red-500 mt-0.5"></i>
          <div>
            <p class="text-red-700 font-semibold mb-2">Terdapat kesalahan:</p>
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      @endif

      <form action="/umkm/register" method="POST" class="space-y-5" id="registerForm">
        @csrf

        <!-- STEP 1: Data Pribadi -->
        <div class="step active" id="step1">
          <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-person-circle text-blue-600"></i>
            Data Pribadi
          </h3>

          <!-- Nama Lengkap -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-person text-blue-600"></i>
              Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="Masukkan nama lengkap Anda">
          </div>

          <!-- Email -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-envelope text-orange-600"></i>
              Email <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="contoh@email.com">
          </div>

          <!-- No Telepon -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-telephone text-teal-600"></i>
              No Telepon <span class="text-red-500">*</span>
            </label>
            <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" placeholder="08123456789">
          </div>

          <!-- Next Button -->
          <button type="button" onclick="nextStep()" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-blue-700 transition shadow-lg flex items-center justify-center gap-2">
            <span>Lanjut ke Data Usaha</span>
            <i class="bi bi-arrow-right"></i>
          </button>
        </div>

        <!-- STEP 2: Data Usaha -->
        <div class="step" id="step2">
          <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
            <i class="bi bi-shop text-green-600"></i>
            Data Usaha & Akun
          </h3>

          <!-- Nama Usaha -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-shop text-green-600"></i>
              Nama Usaha <span class="text-red-500">*</span>
            </label>
            <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha') }}" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition" placeholder="Masukkan nama usaha Anda">
          </div>

          <!-- Username -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-person-badge text-purple-600"></i>
              Username UMKM <span class="text-red-500">*</span>
            </label>
            <input type="text" name="username" id="username" value="{{ old('username') }}" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition" placeholder="username_anda">
          </div>

          <!-- Password -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-key text-red-600"></i>
              Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password" id="password" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition" placeholder="Minimal 6 karakter">
          </div>

          <!-- Konfirmasi Password -->
          <div class="mb-5">
            <label class="flex items-center gap-2 text-gray-700 font-semibold mb-2">
              <i class="bi bi-shield-check text-red-600"></i>
              Konfirmasi Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition" placeholder="Ulangi password">
          </div>

          <!-- Info Box -->
          <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-5">
            <div class="flex items-start gap-2">
              <i class="bi bi-info-circle text-blue-500 mt-0.5"></i>
              <p class="text-sm text-blue-700">
                Setelah mendaftar, akun Anda akan diverifikasi oleh admin. Anda akan menerima notifikasi melalui email setelah akun disetujui.
              </p>
            </div>
          </div>

          <!-- Buttons -->
          <div class="flex gap-3">
            <button type="button" onclick="prevStep()" class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-300 transition flex items-center justify-center gap-2">
              <i class="bi bi-arrow-left"></i>
              <span>Kembali</span>
            </button>
            <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 rounded-lg font-semibold hover:from-green-600 hover:to-blue-700 transition shadow-lg flex items-center justify-center gap-2">
              <i class="bi bi-check-circle"></i>
              <span>Daftar</span>
            </button>
          </div>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-gray-200">
          <p class="text-gray-600">
            Sudah punya akun?
            <a href="/umkm/login" class="text-blue-600 font-semibold hover:text-blue-700 hover:underline transition">Login di sini</a>
          </p>
        </div>
      </form>
    </div>

    <!-- Footer -->
    <div class="text-center mt-6">
      <a href="/" class="inline-flex items-center gap-2 text-white hover:text-gray-200 transition">
        <i class="bi bi-arrow-left"></i>
        <span>Kembali ke Beranda</span>
      </a>
    </div>
  </div>

  <script>
    function nextStep() {
      // Validasi step 1
      const namaLengkap = document.getElementById('nama_lengkap').value;
      const email = document.getElementById('email').value;
      const noTelepon = document.getElementById('no_telepon').value;

      if (!namaLengkap || !email || !noTelepon) {
        showValidationError('Mohon lengkapi semua field pada Step 1');
        return;
      }

      // Hide step 1, show step 2
      document.getElementById('step1').classList.remove('active');
      document.getElementById('step2').classList.add('active');

      // Update progress indicator
      document.getElementById('step1-indicator').classList.remove('bg-green-500', 'text-white');
      document.getElementById('step1-indicator').classList.add('bg-green-200', 'text-green-700');
      document.getElementById('step1-text').classList.remove('text-green-600');
      document.getElementById('step1-text').classList.add('text-green-500');

      document.getElementById('progress-line').classList.remove('bg-gray-300');
      document.getElementById('progress-line').classList.add('bg-green-500');

      document.getElementById('step2-indicator').classList.remove('bg-gray-300', 'text-gray-500');
      document.getElementById('step2-indicator').classList.add('bg-green-500', 'text-white');
      document.getElementById('step2-text').classList.remove('text-gray-400');
      document.getElementById('step2-text').classList.add('text-green-600');

      // Scroll to top
      window.scrollTo({
        top: 0
        , behavior: 'smooth'
      });
    }

    function prevStep() {
      // Hide step 2, show step 1
      document.getElementById('step2').classList.remove('active');
      document.getElementById('step1').classList.add('active');

      // Update progress indicator
      document.getElementById('step1-indicator').classList.remove('bg-green-200', 'text-green-700');
      document.getElementById('step1-indicator').classList.add('bg-green-500', 'text-white');
      document.getElementById('step1-text').classList.remove('text-green-500');
      document.getElementById('step1-text').classList.add('text-green-600');

      document.getElementById('progress-line').classList.remove('bg-green-500');
      document.getElementById('progress-line').classList.add('bg-gray-300');

      document.getElementById('step2-indicator').classList.remove('bg-green-500', 'text-white');
      document.getElementById('step2-indicator').classList.add('bg-gray-300', 'text-gray-500');
      document.getElementById('step2-text').classList.remove('text-green-600');
      document.getElementById('step2-text').classList.add('text-gray-400');

      // Scroll to top
      window.scrollTo({
        top: 0
        , behavior: 'smooth'
      });
    }

  </script>

</body>
</html>
