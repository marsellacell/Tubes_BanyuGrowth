<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semua UMKM - BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

  </style>
</head>
<body class="bg-gray-50">

  <!-- HEADER -->
  <header class="w-full flex items-center justify-between px-4 md:px-6 py-4 shadow-md bg-white sticky top-0 z-50 gap-3">
    <div class="flex items-center gap-2">
      <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-8 md:w-10">
      <h1 class="font-bold text-base md:text-xl text-green-700">BanyuGrowth</h1>
    </div>
    <a href="{{ route('home') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-sm">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>
  </header>

  <!-- CONTENT -->
  <section class="container mx-auto px-4 py-8">
    <div class="mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Semua UMKM Terdaftar</h1>
      <p class="text-gray-600 mt-2">Jelajahi {{ $umkmList->count() }} UMKM yang telah terdaftar dan terverifikasi</p>
    </div>

    @if($umkmList->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($umkmList as $umkm)
      <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 text-center transition-all duration-300 transform hover:-translate-y-1">
        <!-- Logo UMKM -->
        @if($umkm->logo_umkm)
        <div class="w-24 h-24 mx-auto mb-4 rounded-full overflow-hidden border-4 border-green-200 shadow-lg">
          <img src="{{ asset('storage/' . $umkm->logo_umkm) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover">
        </div>
        @else
        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full mx-auto mb-4 border-4 border-green-200 flex items-center justify-center shadow-lg">
          <span class="text-white font-bold text-4xl">{{ strtoupper(substr($umkm->nama_usaha, 0, 1)) }}</span>
        </div>
        @endif

        <!-- Nama UMKM -->
        <h3 class="font-bold text-gray-800 text-lg mb-1">{{ Str::limit($umkm->nama_usaha, 30) }}</h3>

        <!-- Nama Pemilik -->
        <p class="text-sm text-gray-500 mb-2">{{ $umkm->nama_lengkap }}</p>

        <!-- Lokasi -->
        <div class="flex items-center justify-center gap-1 text-gray-600 text-sm mb-3">
          <i class="bi bi-geo-alt text-green-600"></i>
          <span>{{ Str::limit($umkm->alamat ?? 'Banyumas', 25) }}</span>
        </div>

        <!-- Stats -->
        <div class="flex items-center justify-center gap-4 text-sm text-gray-500 mb-4">
          <span title="Jumlah Produk">
            <i class="bi bi-box-seam text-green-600"></i> {{ $umkm->products_count }} Produk
          </span>
          <span title="Total Views">
            <i class="bi bi-eye text-blue-600"></i> {{ number_format($umkm->total_views ?? 0) }}
          </span>
        </div>

        <!-- Profile Link -->
        <div class="pt-3 border-t border-gray-200">
          <a href="{{ route('umkm.profile', $umkm->id) }}" class="inline-flex items-center gap-2 text-sm text-green-600 hover:text-green-700 font-semibold">
            <i class="bi bi-shop"></i> Lihat Profil
          </a>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-20">
      <i class="bi bi-shop text-6xl text-gray-300"></i>
      <p class="text-gray-500 mt-4 text-lg">Belum ada UMKM terdaftar</p>
    </div>
    @endif
  </section>

  <!-- FOOTER -->
  <footer class="mt-12 bg-white py-6 border-t">
    <div class="container mx-auto text-center">
      <p class="text-sm text-gray-600">© 2025 BanyuGrowth. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
