<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Semua Produk | BanyuGrowth</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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

    .search-wrapper {
      position: relative;
      width: 100%;
      max-width: 900px;
      margin-left: 20px;
    }

    @media (max-width: 768px) {
      .search-wrapper {
        margin-left: 0;
        max-width: 100%;
      }
    }

    .search-input {
      width: 100%;
      border-radius: 9999px;
      padding: 8px 42px 8px 16px;
      border: 1px solid #ccc;
      outline: none;
      transition: 0.3s;
    }

    .search-input:focus {
      border-color: #22c55e;
      box-shadow: 0 0 4px rgba(34, 197, 94, 0.4);
    }

    .search-wrapper i {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #666;
      font-size: 18px;
    }

    footer img {
      height: 30px;
    }

    .like-button {
      transition: all 0.3s ease;
      cursor: pointer;
      background: none;
      border: none;
      padding: 0;
    }

    .like-button:hover {
      transform: scale(1.1);
    }

    .like-button.liked i {
      color: #ef4444;
    }

  </style>
</head>
<link rel="icon" type="image/png" href="/assets/img/logo_banyugrowth.png">

<body class="bg-white text-gray-800">

  <!-- HEADER -->
  <header class="w-full flex items-center justify-between px-6 py-4 shadow-md bg-white sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <a href="{{ url('/') }}" class="flex items-center gap-2">
        <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
        <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
      </a>
    </div>
    <div class="flex items-center gap-2">
      <div class="search-wrapper">
        <form action="{{ route('products.search') }}" method="GET" id="searchForm" style="position:relative;">
          <input type="text" id="searchInput" name="q" placeholder="Cari produk atau UMKM..." class="search-input" />
          <button type="submit" style="position:absolute; right:6px; top:50%; transform:translateY(-50%); background:transparent; border:0; padding:6px; cursor:pointer;">
            <i class="bi bi-search" aria-hidden="true"></i>
          </button>
        </form>
      </div>
    </div>
    <div class="flex items-center gap-3">
      @if(session('umkm_id'))
      <a href="{{ route('umkm.dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      @elseif(session('admin_id'))
      <a href="{{ url('/admin/dashboard') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
      @else
      <a href="{{ route('umkm.register.form') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold">
        <i class="bi bi-person-plus"></i> Daftar UMKM
      </a>
      @endif
    </div>
  </header>

  <!-- BREADCRUMB -->
  <section class="mt-6 container mx-auto px-4">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
      <a href="{{ url('/') }}" class="hover:text-green-600">
        <i class="bi bi-house-door"></i> Beranda
      </a>
      <i class="bi bi-chevron-right text-xs"></i>
      <span class="text-green-600 font-semibold">Semua Produk</span>
    </div>

    <div class="flex items-center justify-between">
      <div>
        <h2 class="font-bold text-3xl text-gray-800">Semua Produk UMKM</h2>
        <p class="text-gray-600 mt-2">Menampilkan {{ $produkList->count() }} produk dari UMKM Banyumas</p>
      </div>
      <a href="{{ url('/') }}" class="px-4 py-2 text-green-700 hover:text-green-800 font-semibold">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
    </div>
  </section>

  <!-- PRODUCTS GRID -->
  <section class="mt-8 container mx-auto px-4 mb-10">
    @if($produkList->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      @foreach($produkList as $produk)
      <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 hover:scale-[1.02]">
        <img src="{{ $produk['image'] }}" alt="{{ $produk['nama'] }}" class="w-full h-44 object-cover">
        <div class="p-4 text-center">
          <h3 class="font-semibold text-gray-800 text-lg">{{ $produk['nama'] }}</h3>
          <p class="text-sm text-gray-500 mt-1">{{ Str::limit($produk['deskripsi'], 60) }}</p>
          <p class="text-xs text-gray-400 mt-1">
            <i class="bi bi-shop"></i> {{ $produk['umkm'] }}
          </p>
          <p class="mt-2 text-green-600 font-bold text-lg">Rp{{ number_format($produk['harga'], 0, ',', '.') }}</p>

          <!-- Product Stats -->
          <div class="flex justify-center gap-3 mt-2 text-xs text-gray-500">
            <span title="Views"><i class="bi bi-eye"></i> {{ $produk['jumlah_view'] ?? 0 }}</span>
            <span title="Purchases"><i class="bi bi-cart"></i> {{ $produk['jumlah_klik_beli'] ?? 0 }}</span>
            <span title="Like">
              <i class="bi bi-heart"></i> <span class="like-count">{{ $produk['jumlah_like'] ?? 0 }}</span>
            </span>
          </div>

          <a href="{{ route('products.show', $produk['id']) }}" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded-full text-sm hover:bg-green-700 transition">
            Lihat Produk
          </a>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-20">
      <i class="bi bi-inbox text-6xl text-gray-300"></i>
      <p class="text-gray-500 mt-4 text-lg">Belum ada produk tersedia</p>
      <a href="{{ url('/') }}" class="inline-block mt-4 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Kembali ke Beranda
      </a>
    </div>
    @endif
  </section>

  <!-- FOOTER -->
  <footer class="mt-10 bg-gray-100 py-10 border-t">
    <div class="container mx-auto grid md:grid-cols-3 gap-8 text-center md:text-left">
      <!-- Kolom 1 -->
      <div>
        <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
          <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
          <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
        </div>
        <p class="text-sm text-gray-700 text-justify">
          Banyu Growth adalah sebuah website yang dirancang untuk mempermudah proses pendaftaran dan pendataan UMKM Kabupaten Banyumas yang telah bergabung dalam Aspikmas.
        </p>
      </div>

      <!-- Kolom 2 -->
      <div>
        <h3 class="font-semibold text-green-700 mb-3">Informasi</h3>
        <p><a href="{{ url('/umkm/faq') }}" class="text-gray-700 hover:text-green-600">FAQ (Tanya Jawab)</a></p>
      </div>

      <!-- Kolom 3 -->
      <div>
        <h3 class="font-semibold text-green-700 mb-3">Hubungi Kami</h3>
        <p class="text-sm text-gray-700">Sitapen, Purwanegara, Kec. Purwokerto Utara,<br>Kabupaten Banyumas, Jawa Tengah 53116</p>
        <p class="text-sm mt-2 text-gray-700">09.00 - 17.00 | Senin - Sabtu</p>
        <div class="flex justify-center md:justify-start gap-3 mt-3">
          <a href="https://facebook.com/aspikmas.banyumas" target="_blank" title="Facebook Aspikmas" class="text-blue-600 hover:text-blue-800 text-2xl transition">
            <i class="bi bi-facebook"></i>
          </a>
          <a href="https://www.instagram.com/aspikmart?igsh=N243Nmp2bHVuazNw" target="_blank" title="Instagram Aspikmas" class="text-pink-600 hover:text-pink-800 text-2xl transition">
            <i class="bi bi-instagram"></i>
          </a>
          <a href="https://youtube.com/@aspikmasbaturraden?si=x262q0Xf6R7W_LKN" target="_blank" title="YouTube Aspikmas" class="text-red-600 hover:text-red-800 text-2xl transition">
            <i class="bi bi-youtube"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="container mx-auto text-center mt-8">
      <p class="font-bold text-gray-800">Metode Pembayaran:</p>
      <div class="flex justify-center flex-wrap gap-5 mt-2">
        <img src="/assets/img/mandiri.png" alt="Mandiri">
        <img src="/assets/img/BCA.png" alt="BCA">
        <img src="/assets/img/BRI.png" alt="BRI">
        <img src="/assets/img/BNI.png" alt="BNI">
        <img src="/assets/img/BSI.png" alt="BSI">
        <img src="/assets/img/Qris.png" alt="Qris">
        <img src="/assets/img/Dana.png" alt="Dana">
      </div>
      <p class="text-xs text-gray-500 mt-4">© 2025 BanyuGrowth. All rights reserved.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // --- Like Button AJAX Functionality ---
    document.addEventListener('DOMContentLoaded', function() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      document.querySelectorAll('.like-button').forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const productId = this.getAttribute('data-product-id');
          const likeCountSpan = this.querySelector('.like-count');

          fetch(`/products/${productId}/like`, {
              method: 'POST'
              , headers: {
                'Content-Type': 'application/json'
                , 'X-CSRF-TOKEN': csrfToken
              }
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                likeCountSpan.textContent = data.likes;
                this.classList.add('liked');

                // Animation
                this.style.transform = 'scale(1.2)';
                setTimeout(() => {
                  this.style.transform = 'scale(1)';
                }, 200);
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
        });
      });
    });

  </script>
</body>
</html>
