<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $umkm->nama_usaha }} - Profil UMKM</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

  </style>
  <link rel="icon" type="image/png" href="/assets/img/logo_banyugrowth.png">
</head>

<body class="bg-gray-50">

  <!-- HEADER -->
  <header class="w-full bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex items-center justify-between">
      <!-- Back Button -->
      <a href="{{ url('/') }}" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold">
        <i class="bi bi-arrow-left text-xl"></i>
        <span>Kembali</span>
      </a>

      <!-- Logo -->
      <div class="flex items-center gap-2">
        <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-8">
        <h1 class="font-bold text-lg text-green-700">BanyuGrowth</h1>
      </div>

      <!-- Spacer -->
      <div class="w-24"></div>
    </div>
  </header>

  <!-- UMKM PROFILE SECTION -->
  <section class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
      <!-- Profile Header -->
      <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-white">
        <div class="flex flex-col md:flex-row items-center gap-6">
          <!-- Logo UMKM -->
          @if($umkm->logo_umkm)
          <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-xl flex-shrink-0">
            <img src="{{ asset('storage/' . $umkm->logo_umkm) }}" alt="{{ $umkm->nama_usaha }}" class="w-full h-full object-cover">
          </div>
          @else
          <div class="w-32 h-32 bg-white rounded-full border-4 border-white flex items-center justify-center shadow-xl flex-shrink-0">
            <span class="text-green-600 font-bold text-5xl">{{ strtoupper(substr($umkm->nama_usaha, 0, 1)) }}</span>
          </div>
          @endif

          <!-- UMKM Info -->
          <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $umkm->nama_usaha }}</h1>
            <p class="text-green-100 text-lg mb-3">
              <i class="bi bi-person-circle"></i> {{ $umkm->nama_lengkap }}
            </p>
            <div class="flex flex-wrap gap-4 justify-center md:justify-start">
              <div class="flex items-center gap-2">
                <i class="bi bi-geo-alt-fill"></i>
                <span>{{ $umkm->alamat ?? 'Banyumas' }}</span>
              </div>
              {{-- <div class="flex items-center gap-2">
                <i class="bi bi-envelope-fill"></i>
                <span>{{ $umkm->email }}</span>
            </div>
            <div class="flex items-center gap-2">
              <i class="bi bi-telephone-fill"></i>
              <span>{{ $umkm->no_telepon }}</span>
            </div> --}}
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-3 divide-x divide-gray-200 bg-gray-50">
      <div class="p-6 text-center">
        <div class="text-3xl font-bold text-green-600">{{ $umkm->products_count }}</div>
        <div class="text-sm text-gray-600 mt-1">Total Produk</div>
      </div>
      <div class="p-6 text-center">
        <div class="text-3xl font-bold text-blue-600">{{ number_format($umkm->total_views ?? 0) }}</div>
        <div class="text-sm text-gray-600 mt-1">Total Views</div>
      </div>
      <div class="p-6 text-center">
        <div class="text-3xl font-bold text-purple-600">
          {{ $products->sum('jumlah_like') }}
        </div>
        <div class="text-sm text-gray-600 mt-1">Total Likes</div>
      </div>
    </div>

    <!-- Contact Button -->
    {{-- <div class="p-6 border-t border-gray-200">
        <a href="tel:{{ $umkm->no_telepon }}" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold transition">
    <i class="bi bi-telephone-fill"></i> Hubungi UMKM
    </a>
    </div> --}}
    </div>
  </section>

  <!-- PRODUCTS SECTION -->
  <section class="container mx-auto px-4 pb-12">
    <div class="mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Produk {{ $umkm->nama_usaha }}</h2>
      <p class="text-gray-600">{{ $products->count() }} produk tersedia</p>
    </div>

    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($products as $product)
      <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 hover:scale-[1.02]">
        <img src="{{ $product->image ?? '/assets/img/default-product.jpg' }}" alt="{{ $product->nama_produk }}" class="w-full h-44 object-cover">
        <div class="p-4">
          <h3 class="font-semibold text-gray-800 text-base mb-2">{{ $product->nama_produk }}</h3>
          <p class="text-xs text-gray-500 mb-2">
            <i class="bi bi-tag"></i> {{ $product->category->nama_kategori ?? 'Lainnya' }}
          </p>
          <p class="text-green-600 font-bold text-lg mb-3">
            Rp{{ number_format($product->harga, 0, ',', '.') }}
          </p>

          <!-- Product Stats -->
          <div class="flex justify-center gap-3 mb-3 text-xs text-gray-500">
            <span title="Views"><i class="bi bi-eye"></i> {{ $product->jumlah_view ?? 0 }}</span>
            <span title="Purchases"><i class="bi bi-cart"></i> {{ $product->jumlah_klik_beli ?? 0 }}</span>
            <span title="Like"><i class="bi bi-heart"></i> {{ $product->jumlah_like ?? 0 }}</span>
          </div>

          <a href="{{ route('products.show', $product->id) }}" class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-full text-sm hover:bg-green-700 transition">
            Lihat Detail
          </a>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-white rounded-2xl shadow">
      <i class="bi bi-inbox text-6xl text-gray-300"></i>
      <p class="text-gray-500 mt-4">Belum ada produk dari UMKM ini</p>
    </div>
    @endif
  </section>

  <!-- FOOTER -->
  <footer class="bg-gray-100 py-8 border-t mt-8">
    <div class="container mx-auto text-center">
      <div class="flex items-center justify-center gap-2 mb-3">
        <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-8">
        <h1 class="font-bold text-lg text-green-700">BanyuGrowth</h1>
      </div>
      <p class="text-sm text-gray-600">Platform Digital UMKM Banyumas</p>
      <p class="text-xs text-gray-500 mt-2">© 2025 BanyuGrowth. All rights reserved.</p>
    </div>
  </footer>

</body>
</html>
