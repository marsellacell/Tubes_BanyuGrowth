<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>BanyuGrowth | Home</title>

  <!-- Bootstrap CSS - Load FIRST before Tailwind -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tailwind CSS with Config -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      corePlugins: {
        preflight: false, // Disable Tailwind's base reset to prevent Bootstrap conflicts
      }
    }

  </script>

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

    /* Remove underline from all links */
    a {
      text-decoration: none !important;
    }

    a:hover {
      text-decoration: none !important;
    }

    /* Fix accordion - Override Tailwind completely for accordion section */
    #faqAccordion * {
      box-sizing: border-box;
    }

    #faqAccordion .accordion-collapse {
      visibility: visible !important;
      height: auto !important;
    }

    #faqAccordion .accordion-collapse.collapse:not(.show) {
      display: none;
    }

    #faqAccordion .accordion-collapse.collapse.show {
      display: block;
    }

    #faqAccordion .accordion-collapse.collapsing {
      position: relative;
      height: 0;
      overflow: hidden;
      transition: height 0.35s ease;
      display: block;
    }

    #faqAccordion .accordion-body {
      padding: 1rem 1.25rem;
    }

    /* Like Button */
    .like-button {
      transition: all 0.3s ease;
      cursor: pointer;
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
  <header class="w-full flex items-center justify-between px-4 md:px-6 py-4 shadow-md bg-white sticky top-0 z-50 gap-3">
    <!-- Logo -->
    <div class="flex items-center gap-2 flex-shrink-0">
      <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-8 md:w-10">
      <h1 class="font-bold text-base md:text-xl text-green-700 hidden sm:block">BanyuGrowth</h1>
    </div>

    <!-- Search Bar -->
    <div class="flex-1 max-w-3xl mx-2 md:mx-4">
      <form action="{{ route('products.search') }}" method="GET" class="relative w-full">
        <input type="text" id="searchInput" name="q" placeholder="Cari produk atau UMKM..." value="{{ request('q') ?? '' }}" class="w-full rounded-full px-4 py-2 md:py-3 pr-10 md:pr-12 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition text-sm md:text-base" />
        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-transparent border-0 p-2 cursor-pointer hover:text-green-600 transition">
          <i class="bi bi-search text-gray-600 text-base md:text-lg" aria-hidden="true"></i>
        </button>
      </form>
    </div>

    <!-- Auth Buttons -->
    <div class="flex items-center gap-2 md:gap-3 flex-shrink-0">
      @if(session('umkm_id') || session('admin_id'))
      <!-- Notification Bell -->
      <div class="relative notification-container">
        <button id="notificationBtn" class="relative p-2 text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-lg transition">
          <i class="bi bi-bell text-xl"></i>
          <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold hidden">0</span>
        </button>

        <!-- Notification Dropdown -->
        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 md:w-96 bg-white rounded-xl shadow-2xl border border-gray-200 z-50 max-h-[500px] overflow-hidden">
          <!-- Header -->
          <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-blue-50">
            <h3 class="font-bold text-gray-800 flex items-center gap-2">
              <i class="bi bi-bell-fill text-green-600"></i> Notifikasi
            </h3>
            <button id="markAllReadBtn" class="text-xs text-green-600 hover:text-green-700 font-semibold">
              Tandai Semua Dibaca
            </button>
          </div>

          <!-- Notification List -->
          <div id="notificationList" class="overflow-y-auto max-h-96">
            <!-- Notifications will be loaded here -->
            <div class="flex items-center justify-center py-12">
              <div class="text-center text-gray-400">
                <i class="bi bi-hourglass-split text-4xl mb-2"></i>
                <p>Memuat notifikasi...</p>
              </div>
            </div>
          </div>

          <!-- Footer -->
          <div class="p-3 border-t bg-gray-50 flex gap-2">
            <button id="deleteReadBtn" class="flex-1 text-xs text-gray-600 hover:text-red-600 font-semibold py-2">
              <i class="bi bi-trash"></i> Hapus yang Dibaca
            </button>
          </div>
        </div>
      </div>
      @endif

      @if(session('umkm_id'))
      <!-- UMKM sudah login: tampilkan link ke Dashboard UMKM -->
      <a href="{{ route('umkm.dashboard') }}" class="px-3 md:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-xs md:text-sm whitespace-nowrap">
        <i class="bi bi-speedometer2"></i> <span class="hidden sm:inline">Dashboard</span>
      </a>
      @elseif(session('admin_id'))
      <!-- Admin sudah login: tampilkan link ke Dashboard Admin -->
      <a href="{{ url('/admin/dashboard') }}" class="px-3 md:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-xs md:text-sm whitespace-nowrap">
        <i class="bi bi-speedometer2"></i> <span class="hidden sm:inline">Dashboard</span>
      </a>
      @else
      <!-- Guest: tampilkan Login -->
      <a href="{{ route('landing') }}" class="px-3 md:px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-xs md:text-sm whitespace-nowrap">
        <i class="bi bi-box-arrow-in-right"></i> <span class="hidden sm:inline">Login</span>
      </a>
      @endif
    </div>
  </header>

  <!-- SLIDER -->
  <section class="mt-4 container mx-auto px-4">
    <div id="mainSlider" class="carousel slide rounded-xl overflow-hidden shadow" data-bs-ride="carousel">
      <!-- Indicators -->
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <!-- Slides -->
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="/assets/img/slide_1.png" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
          <img src="/assets/img/slide_2.png" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
          <img src="/assets/img/slide_3.png" class="d-block w-100" alt="Slide 3">
        </div>
      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <!-- KATEGORI -->
  <section class="mt-8 container mx-auto px-4">
    <h2 class="font-bold text-lg mb-3">Kategori Produk</h2>

    <div class="flex flex-row gap-5 flex-wrap text-center">
      @forelse($categories as $category)
      <a href="{{ route('categories.show', $category->slug ?? $category->id) }}" class="flex flex-col items-center group transition transform hover:scale-105 cursor-pointer">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-2 group-hover:bg-green-200 transition">
          <i class="bi bi-tag text-3xl text-green-600"></i>
        </div>
        <p class="font-medium text-gray-800 group-hover:text-green-700 text-sm">{{ $category->nama_kategori }}</p>
        <span class="text-xs text-gray-500">({{ $category->products_count }} produk)</span>
      </a>
      @empty
      <div class="col-span-full text-center text-gray-500 py-8">
        Belum ada kategori tersedia
      </div>
      @endforelse
    </div>
  </section>

  <!-- UMKM 2025 -->
  <section class="mt-12 container mx-auto px-4">
    <div class="flex justify-between items-center mb-3">
      <h2 class="font-bold text-lg">Rekomendasi Produk UMKM</h2>
      <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-700 font-semibold text-sm">
        Lihat Semua <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    @if($produkList->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      @foreach($produkList->take(3) as $produk)
      <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 hover:scale-[1.02] produk-card" data-name="{{ $produk['nama'] }}">
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

      <!-- Card Lihat Semua -->
      <a href="{{ route('products.index') }}" class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-300 border-dashed rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 hover:scale-[1.02] flex items-center justify-center p-8">
        <div class="text-center">
          <i class="bi bi-grid-3x3 text-green-600 text-5xl mb-3"></i>
          <h3 class="font-bold text-green-700 text-lg mb-2">Lihat Semua Produk</h3>
          <p class="text-sm text-green-600">{{ $produkList->count() }} produk tersedia</p>
          <div class="mt-3 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full text-sm font-semibold">
            Jelajahi <i class="bi bi-arrow-right ml-2"></i>
          </div>
        </div>
      </a>
    </div>
    @else
    <div class="text-center py-12">
      <i class="bi bi-inbox text-6xl text-gray-300"></i>
      <p class="text-gray-500 mt-4">Belum ada produk tersedia</p>
    </div>
    @endif
  </section>



  <!-- INFORMASI TERKAIT -->
  <section class="mt-8 container mx-auto px-4">
    <h2 class="font-bold text-lg mb-3">Informasi Terkait</h2>

    @if($informations && $informations->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      @foreach($informations as $info)
      <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative">
        <a href="{{ route('information.show', $info->slug) }}" class="block relative overflow-hidden group">
          @if($info->banner)
          <img src="{{ asset('storage/' . $info->banner) }}" alt="{{ $info->judul }}" class="w-full h-56 sm:h-72 md:h-[25rem] object-cover transition-transform duration-500 group-hover:scale-105">
          @else
          <div class="w-full h-56 sm:h-72 md:h-[25rem] bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
            <i class="bi bi-newspaper text-white text-6xl opacity-50"></i>
          </div>
          @endif
          <!-- Overlay with title -->
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4">
            <h3 class="text-white font-bold text-base sm:text-lg line-clamp-2">{{ $info->judul }}</h3>
            <p class="text-white text-xs sm:text-sm opacity-90 mt-1">
              <i class="bi bi-calendar3"></i> {{ $info->created_at->format('d M Y') }}
            </p>
          </div>
        </a>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-gray-50 rounded-xl">
      <i class="bi bi-newspaper text-6xl text-gray-300"></i>
      <p class="text-gray-500 mt-4">Belum ada informasi tersedia</p>
    </div>
    @endif
  </section>

  <!-- REKOMENDASI UMKM -->
  <section class="mt-8 container mx-auto px-4">
    <div class="flex justify-between items-center mb-3">
      <h2 class="font-bold text-xl">Rekomendasi UMKM</h2>
      <a href="{{ route('umkm.all') }}" class="text-green-600 hover:text-green-700 font-semibold text-sm">
        Lihat Semua <i class="bi bi-arrow-right"></i>
      </a>
    </div>

    @if($topUmkm->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      @foreach($topUmkm as $umkm)
      <!-- Kartu UMKM -->
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
    <div class="text-center py-12">
      <i class="bi bi-shop text-6xl text-gray-300"></i>
      <p class="text-gray-500 mt-4">Belum ada UMKM terdaftar</p>
    </div>
    @endif
  </section>

  </div>
  </a>



  </div>
  </div>
  </section>

  </section>

  <!-- PERTANYAAN UMUM -->
  <section class="mt-8 container mx-auto px-4">
    <h2 class="font-bold text-xl mb-3">Pertanyaan Umum</h2>
    <div class="accordion" id="faqAccordion">

      <!-- Item 1 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading1">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
            Bagaimana cara mengubah data usaha setelah terdaftar?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Setelah Anda mendaftarkan UMKM Anda di sistem BanyuGrowth dan akun Anda telah diverifikasi oleh administrator, Anda dapat melakukan pengelolaan data usaha kapan saja dengan login ke sistem. Proses pengubahan data dilakukan secara mandiri oleh pemilik UMKM melalui antarmuka yang telah dirancang secara intuitif dan mudah digunakan, baik dari desktop maupun perangkat mobile.
            <br><br>
            <strong>Berikut adalah tahapan untuk mengubah data usaha:</strong>
            <ul class="list-disc pl-5 mt-2">
              <li>Login menggunakan akun UMKM.</li>
              <li>Akses halaman profil usaha.</li>
              <li>Klik tombol "Edit" pada data usaha.</li>
              <li>Ubah informasi yang diperlukan (nama usaha, alamat, kontak, deskripsi, dll).</li>
              <li>Klik "Simpan".</li>
            </ul>
            Sistem akan memverifikasi data sebelum menyimpannya.
          </div>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="accordion-item mt-2">
        <h2 class="accordion-header" id="heading2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
            Apa saja data yang perlu disiapkan saat mendaftar UMKM?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Sebelum melakukan pendaftaran UMKM di platform BanyuGrowth, siapkan informasi dan dokumen pendukung berikut:
            <ul class="list-disc pl-5 mt-2">
              <li><strong>Identitas Pemilik Usaha:</strong> Nama lengkap, email aktif, dan nomor telepon yang bisa dihubungi.</li>
              <li><strong>Akun Pengguna:</strong> Username unik dan password yang aman.</li>
              <li><strong>Informasi Usaha:</strong> Nama UMKM, kategori, alamat lengkap, dan deskripsi singkat usaha.</li>
              <li><strong>Dokumen Legalitas:</strong> Surat izin usaha atau sertifikat pendukung dalam format PDF/JPG.</li>
            </ul>
            Semua data ini diisi di halaman "Daftar sebagai UMKM". Setelah diunggah, admin akan memverifikasi sebelum akun aktif.
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="accordion-item mt-2">
        <h2 class="accordion-header" id="heading3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
            Keuntungan mendaftarkan UMKM dengan BanyuGrowth
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Mendaftar UMKM Anda di BanyuGrowth membawa berbagai keuntungan:
            <ul class="list-disc pl-5 mt-2">
              <li>Kemudahan Pengelolaan Data Usaha</li>
              <li>Pencatatan Data Terstruktur</li>
              <li>Akses ke Statistik dan Laporan</li>
              <li>Peningkatan Akses Informasi</li>
              <li>Keamanan Data Terjamin</li>
              <li>Integrasi dengan Layanan Eksternal</li>
            </ul>
            Dengan BanyuGrowth, UMKM tumbuh dalam ekosistem digital yang terhubung dan inklusif.
          </div>
        </div>
      </div>

      <!-- Item 4 -->
      <div class="accordion-item mt-2">
        <h2 class="accordion-header" id="heading4">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
            Cara Daftar/Registrasi di Pasar Digital UMKM
          </button>
        </h2>
        <div id="faq4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Pendaftaran di sistem BanyuGrowth mudah dilakukan secara online:
            <ol class="list-decimal pl-5 mt-2">
              <li>Kunjungi website resmi BanyuGrowth.</li>
              <li>Klik "Daftar sebagai UMKM".</li>
              <li>Isi formulir pendaftaran lengkap (nama, kontak, data usaha).</li>
              <li>Unggah dokumen legalitas usaha (PDF/JPG).</li>
              <li>Klik "Kirim" dan tunggu proses verifikasi admin.</li>
            </ol>
            Setelah akun aktif, UMKM bisa mengakses fitur pengelolaan data, laporan, dan informasi pembinaan.
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- FOOTER -->
  <footer class="mt-10 bg-gray-100 pt-10 border-t">
    <div class="container flex flex-row justify-evenly gap-8 text-center md:text-left">
      <!-- Kolom 1 -->
      <div>
        <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
          <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
          <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
        </div>
        <p class="text-sm text-gray-700 text-justify max-w-96">
          Banyu Growth adalah sebuah website yang dirancang untuk mempermudah proses pendaftaran dan pendataan UMKM Kabupaten Banyumas yang telah bergabung dalam Aspikmas. Platform ini membantu pelaku UMKM mengelola data usaha, mendaftar secara online, serta mempermudah verifikasi dan pemantauan oleh pihak pengelola.
        </p>
      </div>

      <!-- Kolom 2 -->
      <div>
        <h3 class="font-semibold text-green-700 mb-3">Informasi</h3>

        <p><a href="{{ url('/faq') }}" class="text-gray-700 hover:text-green-600">FAQ (Tanya Jawab)</a></p>
      </div>

      <!-- Kolom 3 -->
      <div>
        <h3 class="font-semibold text-green-700 mb-3">Hubungi Kami</h3>
        <div class="flex justify-center items-center">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.3998196383886!2d109.235393573637!3d-7.420926892589536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655f5c88b415e1%3A0x12dc7703a7249995!2sGaleri%20UKM%20Banyumas%20Raya!5e0!3m2!1sid!2sid!4v1762241656751!5m2!1sid!2sid" width="300" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        </div>
        <p class="text-sm text-gray-700">Sitapen, Purwanegara, Kec. Purwokerto Utara,<br>Kabupaten Banyumas, Jawa Tengah 53116</p>
        <p class="text-sm mt-2 text-gray-700">09.00 - 17.00 | Senin - Sabtu</p>
        <div class="flex justify-center items-center gap-3 mt-3">
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

        <p class="text-sm mt-2 text-gray-500">Layanan Pengaduan Pengguna</p>
      </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="container mx-auto text-center mt-8">
      <p class="font-bold text-gray-800">Metode Pembayaran:</p>
      <div class="flex justify-center flex-wrap gap-5 mt-2">
        <img src="/assets/img/mandiri.png" alt="Mandiri" class="h-8 w-auto object-contain">
        <img src="/assets/img/BCA.png" alt="BCA" class="h-8 w-auto object-contain">
        <img src="/assets/img/BRI.png" alt="BRI" class="h-8 w-auto object-contain">
        <img src="/assets/img/BNI.png" alt="BNI" class="h-8 w-auto object-contain">
        <img src="/assets/img/BSI.png" alt="BSI" class="h-8 w-auto object-contain">
        <img src="/assets/img/Qris.png" alt="Qris" class="h-8 w-auto object-contain">
        <img src="/assets/img/Dana.png" alt="Dana" class="h-8 w-auto object-contain">
      </div>
      <p class="text-xs text-gray-500 mt-4">© 2025 BanyuGrowth. All rights reserved.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // --- Notification System ---
    @if(session('umkm_id') || session('admin_id'))
    let notificationsData = [];

    // Toggle notification dropdown
    document.getElementById('notificationBtn')?.addEventListener('click', function(e) {
      e.stopPropagation();
      const dropdown = document.getElementById('notificationDropdown');
      dropdown.classList.toggle('hidden');
      if (!dropdown.classList.contains('hidden')) {
        loadNotifications();
      }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      const container = document.querySelector('.notification-container');
      const dropdown = document.getElementById('notificationDropdown');
      if (container && !container.contains(e.target)) {
        dropdown?.classList.add('hidden');
      }
    });

    // Load notifications
    function loadNotifications() {
      fetch('/notifications')
        .then(response => response.json())
        .then(data => {
          notificationsData = data.notifications;
          updateNotificationBadge(data.unread_count);
          renderNotifications(data.notifications);
        })
        .catch(error => console.error('Error loading notifications:', error));
    }

    // Update badge
    function updateNotificationBadge(count) {
      const badge = document.getElementById('notificationBadge');
      if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.classList.remove('hidden');
      } else {
        badge.classList.add('hidden');
      }
    }

    // Render notifications
    function renderNotifications(notifications) {
      const listContainer = document.getElementById('notificationList');

      if (notifications.length === 0) {
        listContainer.innerHTML = `
          <div class="flex items-center justify-center py-12">
            <div class="text-center text-gray-400">
              <i class="bi bi-inbox text-6xl mb-2"></i>
              <p>Tidak ada notifikasi</p>
            </div>
          </div>
        `;
        return;
      }

      listContainer.innerHTML = notifications.map(notif => `
        <div class="notification-item p-4 hover:bg-gray-50 transition cursor-pointer ${notif.is_read ? 'opacity-60' : 'bg-blue-50'}" 
             data-id="${notif.id}" 
             data-link="${notif.link || '#'}"
             onclick="handleNotificationClick(${notif.id}, '${notif.link || ''}')">
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
              ${getNotificationIcon(notif.type)}
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="font-semibold text-gray-800 text-sm mb-1">${notif.title}</h4>
              <p class="text-xs text-gray-600 mb-2 line-clamp-2">${notif.message}</p>
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-400">
                  <i class="bi bi-clock"></i> ${notif.time_ago}
                </span>
                ${!notif.is_read ? '<span class="text-xs text-blue-600 font-semibold"><i class="bi bi-circle-fill" style="font-size: 6px;"></i> Baru</span>' : ''}
              </div>
            </div>
            <button onclick="deleteNotification(event, ${notif.id})" class="text-gray-400 hover:text-red-600 transition">
              <i class="bi bi-x-lg text-sm"></i>
            </button>
          </div>
        </div>
      `).join('');
    }

    // Get icon based on notification type
    function getNotificationIcon(type) {
      const icons = {
        'umkm_verified': '<i class="bi bi-check-circle-fill text-green-500 text-2xl"></i>',
        'umkm_registered': '<i class="bi bi-person-plus-fill text-blue-500 text-2xl"></i>',
        'product_liked': '<i class="bi bi-heart-fill text-red-500 text-2xl"></i>',
        'product_sold': '<i class="bi bi-cart-check-fill text-green-500 text-2xl"></i>',
        'product_added': '<i class="bi bi-plus-circle-fill text-blue-500 text-2xl"></i>',
        'product_updated': '<i class="bi bi-pencil-square text-orange-500 text-2xl"></i>',
        'profile_updated': '<i class="bi bi-person-circle text-purple-500 text-2xl"></i>',
        'default': '<i class="bi bi-bell-fill text-gray-500 text-2xl"></i>'
      };
      return icons[type] || icons['default'];
    }

    // Handle notification click
    function handleNotificationClick(id, link) {
      // Mark as read
      fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      }).then(() => {
        loadNotifications(); // Reload to update badge
        if (link && link !== '#' && link !== '') {
          window.location.href = link;
        }
      });
    }

    // Delete notification
    function deleteNotification(event, id) {
      event.stopPropagation();
      fetch(`/notifications/${id}`, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      }).then(() => {
        loadNotifications();
      });
    }

    // Mark all as read
    document.getElementById('markAllReadBtn')?.addEventListener('click', function() {
      fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      }).then(() => {
        loadNotifications();
      });
    });

    // Delete all read
    document.getElementById('deleteReadBtn')?.addEventListener('click', function() {
      fetch('/notifications/delete-read', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        }
      }).then(() => {
        loadNotifications();
      });
    });

    // Initial load and polling
    loadNotifications();
    setInterval(loadNotifications, 30000); // Refresh every 30 seconds
    @endif

    // --- Realtime JS filter for produk cards (client-side) ---
    const searchInput = document.getElementById('searchInput');
    const produkCards = Array.from(document.querySelectorAll('.produk-card'));

    function filterCardsRealtime(query) {
      const q = (query || '').trim().toLowerCase();
      if (!q) {
        produkCards.forEach(c => c.style.display = '');
        return;
      }
      produkCards.forEach(card => {
        const name = (card.dataset.name || '').toLowerCase();
        if (name.includes(q)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    }

    // filter on typing
    searchInput.addEventListener('input', (e) => {
      filterCardsRealtime(e.target.value);
    });

    // initialize filter if page loaded with query (from Laravel)
    document.addEventListener('DOMContentLoaded', () => {
      const initQ = new URLSearchParams(window.location.search).get('q') || '';
      if (initQ) {
        searchInput.value = initQ;
        filterCardsRealtime(initQ);
      }
    });

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
