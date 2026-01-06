<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

  <div class="bg-white w-96 rounded-xl shadow-lg p-8">
    <!-- Header with Icon -->
    <div class="text-center mb-6">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-3">
        <i class="bi bi-shield-check text-blue-600 text-3xl"></i>
      </div>
      <h2 class="text-2xl font-bold text-gray-700">Login Admin</h2>
      <p class="text-sm text-gray-500 mt-1">Masuk ke panel administrator</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
      {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label class="block font-semibold text-gray-700 mb-2">
          <i class="bi bi-person-circle"></i> Username
        </label>
        <input type="text" name="username" value="{{ old('username') }}" required class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
      </div>

      <div class="mb-6">
        <label class="block font-semibold text-gray-700 mb-2">
          <i class="bi bi-lock-fill"></i> Password
        </label>
        <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="{{ route('landing') }}" class="text-sm text-gray-600 hover:text-blue-600 transition">
        <i class="bi bi-arrow-left"></i> Kembali ke halaman utama
      </a>
    </div>
  </div>

</body>
</html>
