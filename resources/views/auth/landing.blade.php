<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BanyuGrowth - Masuk Sebagai</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      position: relative;
      min-height: 100vh;
      background: linear-gradient(to top, #4095BA 0%, #7BD87D 100%);
      background-size: 400% 400%;
      animation: gradientShift 15s ease infinite;
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

    @keyframes gradientShift {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .card-hover {
      transition: all 0.3s ease;
    }

    .card-hover:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .icon-box {
      width: 50px;
      height: 50px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
    }

    .logo-text {
      background: linear-gradient(135deg, #4095BA 0%, #7BD87D 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .illustration-bg {
      position: absolute;
      right: 0;
      bottom: 0;
      height: 100%;
      width: 50%;
      z-index: 0;
    }

    .illustration-bg img {
      height: 100%;
      width: 100%;
      object-fit: fill;
      object-position: left center;
    }

  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

  <!-- Background Illustration -->
  <div class="illustration-bg hidden lg:block">
    <img src="/assets/bg/people.png" alt="BanyuGrowth Platform">
  </div>

  <div class="w-full max-w-6xl flex items-center justify-between gap-16">

    <!-- LEFT CARD -->
    <div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">
      <!-- Logo -->
      <div class="flex items-center gap-3 mb-8">
        <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
          <i class="bi bi-building text-white text-2xl"></i>
        </div>
        <div>
          <h1 class="text-2xl font-bold logo-text">BanyuGrowth</h1>
          <p class="text-xs text-gray-500">Platform UMKM Lokal</p>
        </div>
      </div>

      <h2 class="text-2xl font-bold text-gray-800 mb-2">Masuk sebagai</h2>
      <p class="text-gray-500 text-sm mb-8">Pilih jenis akun untuk melanjutkan</p>

      <div class="space-y-4">
        <!-- UMKM Button -->
        <a href="{{ route('umkm.login.form') }}" class="card-hover flex items-center gap-4 p-4 border-2 border-gray-200 rounded-2xl hover:border-green-400 hover:bg-green-50 transition-all group">
          <div class="icon-box bg-gradient-to-br from-green-400 to-green-500 shadow-lg group-hover:shadow-green-300">
            <i class="bi bi-shop text-white"></i>
          </div>
          <div class="flex-1">
            <h3 class="font-semibold text-gray-800 text-lg">UMKM</h3>
            <p class="text-xs text-gray-500">Kelola produk dan toko Anda</p>
          </div>
          <i class="bi bi-chevron-right text-gray-400 group-hover:text-green-500 transition-colors"></i>
        </a>

        <!-- Admin Button -->
        <a href="{{ route('admin.login.form') }}" class="card-hover flex items-center gap-4 p-4 border-2 border-gray-200 rounded-2xl hover:border-blue-400 hover:bg-blue-50 transition-all group">
          <div class="icon-box bg-gradient-to-br from-blue-400 to-blue-500 shadow-lg group-hover:shadow-blue-300">
            <i class="bi bi-person-circle text-white"></i>
          </div>
          <div class="flex-1">
            <h3 class="font-semibold text-gray-800 text-lg">Admin</h3>
            <p class="text-xs text-gray-500">Kelola sistem dan verifikasi</p>
          </div>
          <i class="bi bi-chevron-right text-gray-400 group-hover:text-blue-500 transition-colors"></i>
        </a>
      </div>

      <div class="mt-8 pt-6 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-600">
          Belum punya akun BanyuGrowth?
          <a href="{{ route('umkm.register.form') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition-colors">Daftar</a>
        </p>
      </div>
    </div>

    <!-- Spacer for right side -->
    <div class="hidden lg:block flex-1"></div>

  </div>

</body>
</html>
