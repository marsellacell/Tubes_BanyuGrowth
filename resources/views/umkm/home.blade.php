<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BanyuGrowth | Home</title>

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

    .category-item img {
      width: 70px;
      height: 70px;
      object-fit: contain;
      margin: 0 auto;
    }

    .category-item p {
      font-size: 14px;
      margin-top: 6px;
    }

    footer img {
      height: 30px;
    }

    .search-wrapper {
      position: relative;
      width: 900px;
      margin-left: 20px;
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

    .accordion-button:focus {
      box-shadow: none;
    }

    /* Fix accordion collapse - remove transition that causes text to disappear */
    .accordion-collapse {
      /* Removed: transition: height 0.3s ease; */
    }

    /* Ensure accordion body stays visible */
    .accordion-body {
      display: block !important;
      visibility: visible !important;
      opacity: 1 !important;
    }

    /* small helper for hidden dropdowns on mobile */
    .dropdown-hidden {
      display: none;
    }

  </style>
</head>
<link rel="icon" type="image/png" href="/assets/img/logo_banyugrowth.png">

<body class="bg-white text-gray-800">

  <!-- HEADER -->
  <header class="w-full flex items-center justify-between px-6 py-4 shadow-md bg-white sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
      <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
      <div class="search-wrapper">
        <!-- SEARCH: form untuk Laravel route + input memiliki id untuk realtime JS -->
        <form action="/umkm/search" method="GET" id="searchForm" style="position:relative;">
          <input type="text" id="searchInput" name="q" placeholder="Cari produk atau UMKM..." class="search-input" value="{{ request('q') ?? '' }}" />
          <button type="submit" style="position:absolute; right:6px; top:50%; transform:translateY(-50%); background:transparent; border:0; padding:6px; cursor:pointer;">
            <i class="bi bi-search" aria-hidden="true"></i>
          </button>
        </form>
      </div>
    </div>
    <div class="flex items-center gap-3">
      <!-- NOTIFIKASI: tetap di tombol lonceng, ditambah dropdown kecil -->
      <div class="relative">
        <button id="notifToggle" class="text-xl" aria-expanded="false" aria-controls="notifBox">
          <i class="bi bi-bell"></i>
          <span id="notifCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">3</span>
        </button>

        <div id="notifBox" class="dropdown-hidden absolute right-0 mt-2 w-72 bg-white border rounded-lg shadow-lg p-3 z-50">
          <p class="text-sm font-semibold text-gray-700 mb-2">Notifikasi</p>
          <ul class="space-y-2 text-sm text-gray-600">
            <li class="flex items-start gap-2"><span>✅</span><span>Profil berhasil diperbarui</span></li>
            <li class="flex items-start gap-2"><span>🛒</span><span>Produk baru telah ditambahkan</span></li>
            <li class="flex items-start gap-2"><span>📄</span><span>Dokumen Anda sedang diverifikasi</span></li>
          </ul>
        </div>
      </div>

      <!-- PROFIL: tetap di ikon person, tambahkan dropdown menu -->
      <div class="relative">
        <button id="profileToggle" class="text-2xl" aria-expanded="false" aria-controls="profileMenu">
          <i class="bi bi-person-circle"></i>
        </button>

        <div id="profileMenu" class="dropdown-hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg py-2 z-50">
          <a href="/umkm/profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100">Lihat Profil</a>
          <a href="/umkm/edit-profil" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100">Edit Profil</a>
          <a href="/umkm/logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100">Keluar</a>
        </div>
      </div>
    </div>
  </header>

  <!-- SLIDER -->
  <section class="mt-4 container mx-auto">
    <div id="mainSlider" class="carousel slide rounded-xl overflow-hidden shadow" data-bs-ride="carousel">
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
    </div>
  </section>

  <!-- KATEGORI -->
  <section class="mt-8 container mx-auto px-4">
    <h2 class="font-bold text-lg mb-3">Kategori</h2>

    <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-6 text-center">

      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/fashion_pria.png" alt="Fashion Pria" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Fashion Pria</p>
      </div>

      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/fashion_wanita.png" alt="Fashion Wanita" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Fashion Wanita</p>
      </div>

      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/peralatan_dapur.png" alt="Peralatan Dapur" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Peralatan Dapur</p>
      </div>

      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/perawatan_tubuh.png" alt="Perawatan Tubuh" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Perawatan Tubuh</p>
      </div>


      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/rumah_tangga.png" alt="Rumah Tangga" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Rumah Tangga</p>
      </div>

      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/makanan_dan_minuman.png" alt="Makanan & Minuman" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Makanan & Minuman</p>
      </div>

      <div class="flex flex-col items-center group transition transform hover:scale-105">
        <img src="/assets/img/sovenir_dan_merchandise.png" alt="Sovenir & Merchandise" class="w-16 h-16 object-contain mb-2 group-hover:drop-shadow-lg transition">
        <p class="font-medium text-gray-800 group-hover:text-green-700">Sovenir & Merchandise</p>
      </div>


    </div>
  </section>

  <!-- UMKM 2025 -->
  <section class="mt-12 container mx-auto">
    <h2 class="font-bold text-lg mb-3">UMKM 2025</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      @foreach($produkList as $produk)
      <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-1 hover:scale-[1.02] produk-card" data-name="{{ $produk['nama'] }}">
        <img src="{{ $produk['image'] }}" alt="{{ $produk['nama'] }}" class="w-full h-44 object-cover">
        <div class="p-4 text-center">
          <h3 class="font-semibold text-gray-800 text-lg">{{ $produk['nama'] }}</h3>
          <p class="text-sm text-gray-500 mt-1">{{ $produk['deskripsi'] }}</p>
          <p class="mt-2 text-green-600 font-bold text-lg">Rp{{ number_format($produk['harga'], 0, ',', '.') }}</p>
          <a href="{{ route('products.show', $produk['id']) }}" class="inline-block mt-3 px-4 py-2 bg-green-600 text-white rounded-full text-sm hover:bg-green-700 transition">
            Lihat Produk
          </a>
        </div>
      </div>
      @endforeach
    </div>
  </section>



  <!-- INFORMASI TERKAIT -->
  <section class="mt-8 container mx-auto px-4">
    <h2 class="font-bold text-lg mb-3">Informasi Terkait</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <!-- Kartu 1 -->
      <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="overflow-hidden">
          <a href="/umkm/informasi/1">
            <img src="/assets/img/informasi_1.png" alt="Informasi 1" class="w-full h-56 sm:h-64 md:h-72 object-cover transition-transform duration-500 hover:scale-105">
          </a>
        </div>
      </div>

      <!-- Kartu 2 -->
      <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="overflow-hidden">
          <a href="/umkm/informasi/2">
            <img src="/assets/img/informasi_2.png" alt="Informasi 2" class="w-full h-56 sm:h-64 md:h-72 object-cover transition-transform duration-500 hover:scale-105">
          </a>
        </div>
      </div>

      <!-- Kartu 3 -->
      <div class="bg-gray-100 rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="overflow-hidden">
          <a href="/umkm/informasi/3">
            <img src="/assets/img/informasi_3.png" alt="Informasi 3" class="w-full h-56 sm:h-64 md:h-72 object-cover transition-transform duration-500 hover:scale-105">
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- REKOMENDASI UMKM -->
  <section class="mt-10 container mx-auto">
    <h2 class="font-bold text-2xl mb-5 text-center">Rekomendasi UMKM</h2>

    <!-- Kotak besar -->
    <div class="bg-white rounded-3xl shadow-lg border border-green-200 p-6">

      <!-- Grid 9 UMKM -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">

        <!-- Kartu UMKM -->
        <a href="/umkm/produk/1" class="bg-green-50 rounded-xl shadow hover:shadow-lg p-4 text-center transition transform hover:-translate-y-1 block">
          <img src="/assets/img/logo_produk_1.jpg" alt="UMKM 1" class="w-20 h-20 object-cover mx-auto rounded-full border border-green-300">
          <h3 class="mt-3 font-semibold text-gray-800 text-sm md:text-base">Delicious Cookis</h3>
          <div class="flex items-center justify-center gap-1 mt-1 text-gray-600 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c3.727 0 6.75 2.97 6.75 6.75 0 4.32-6.75 12.75-6.75 12.75S5.25 13.32 5.25 9c0-3.78 3.023-6.75 6.75-6.75z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
            </svg>
            <span>Purwokerto Selatan</span>
          </div>
        </a>

        <a href="/umkm/produk/2" class="bg-green-50 rounded-xl shadow hover:shadow-lg p-4 text-center transition transform hover:-translate-y-1 block">
          <img src="/assets/img/logo_produk_2.jpg" alt="UMKM 2" class="w-20 h-20 object-cover mx-auto rounded-full border border-green-300">
          <h3 class="mt-3 font-semibold text-gray-800 text-sm md:text-base">Cookies Bear</h3>
          <div class="flex items-center justify-center gap-1 mt-1 text-gray-600 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c3.727 0 6.75 2.97 6.75 6.75 0 4.32-6.75 12.75-6.75 12.75S5.25 13.32 5.25 9c0-3.78 3.023-6.75 6.75-6.75z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
            </svg>
            <span>Purwokerto Selatan</span>
          </div>
        </a>

        <a href="/umkm/produk/3" class="bg-green-50 rounded-xl shadow hover:shadow-lg p-4 text-center transition transform hover:-translate-y-1 block">
          <img src="/assets/img/logo_produk_3.jpg" alt="UMKM 3" class="w-20 h-20 object-cover mx-auto rounded-full border border-green-300">
          <h3 class="mt-3 font-semibold text-gray-800 text-sm md:text-base">Liceria Juice</h3>
          <div class="flex items-center justify-center gap-1 mt-1 text-gray-600 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c3.727 0 6.75 2.97 6.75 6.75 0 4.32-6.75 12.75-6.75 12.75S5.25 13.32 5.25 9c0-3.78 3.023-6.75 6.75-6.75z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
            </svg>
            <span>Purwokerto Selatan</span>
          </div>
        </a>

        <a href="/umkm/produk/4" class="bg-green-50 rounded-xl shadow hover:shadow-lg p-4 text-center transition transform hover:-translate-y-1 block">
          <img src="/assets/img/logo_produk_4.jpg" alt="UMKM 4" class="w-20 h-20 object-cover mx-auto rounded-full border border-green-300">
          <h3 class="mt-3 font-semibold text-gray-800 text-sm md:text-base">Choco Banana</h3>
          <div class="flex items-center justify-center gap-1 mt-1 text-gray-600 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c3.727 0 6.75 2.97 6.75 6.75 0 4.32-6.75 12.75-6.75 12.75S5.25 13.32 5.25 9c0-3.78 3.023-6.75 6.75-6.75z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
            </svg>
            <span>Purwokerto Selatan</span>
          </div>
        </a>

        <a href="/umkm/produk/5" class="bg-green-50 rounded-xl shadow hover:shadow-lg p-4 text-center transition transform hover:-translate-y-1 block">
          <img src="/assets/img/logo_produk_5.jpg" alt="UMKM 5" class="w-20 h-20 object-cover mx-auto rounded-full border border-green-300">
          <h3 class="mt-3 font-semibold text-gray-800 text-sm md:text-base">Chocolate</h3>
          <div class="flex items-center justify-center gap-1 mt-1 text-gray-600 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c3.727 0 6.75 2.97 6.75 6.75 0 4.32-6.75 12.75-6.75 12.75S5.25 13.32 5.25 9c0-3.78 3.023-6.75 6.75-6.75z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
            </svg>
            <span>Purwokerto Selatan</span>
          </div>
        </a>

        <a href="/umkm/produk/6" class="bg-green-50 rounded-xl shadow hover:shadow-lg p-4 text-center transition transform hover:-translate-y-1 block">
          <img src="/assets/img/logo_produk_6.jpg" alt="UMKM 6" class="w-20 h-20 object-cover mx-auto rounded-full border border-green-300">
          <h3 class="mt-3 font-semibold text-gray-800 text-sm md:text-base">Miss Crafify</h3>
          <div class="flex items-center justify-center gap-1 mt-1 text-gray-600 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-green-600">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.25c3.727 0 6.75 2.97 6.75 6.75 0 4.32-6.75 12.75-6.75 12.75S5.25 13.32 5.25 9c0-3.78 3.023-6.75 6.75-6.75z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
            </svg>
            <span>Purwokerto Selatan</span>
          </div>
        </a>

      </div>
    </div>
  </section>

  </section>

  <!-- PERTANYAAN UMUM -->
  <section class="mt-10 container mx-auto">
    <h2 class="font-bold text-lg mb-3">Pertanyaan Umum</h2>
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
  <footer class="mt-10 bg-gray-100 py-10 border-t">
    <div class="container mx-auto grid md:grid-cols-3 gap-8 text-center md:text-left">
      <!-- Kolom 1 -->
      <div>
        <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
          <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
          <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
        </div>
        <p class="text-sm text-gray-700 text-justify">
          Banyu Growth adalah sebuah website yang dirancang untuk mempermudah proses pendaftaran dan pendataan UMKM Kabupaten Banyumas yang telah bergabung dalam Aspikmas. Platform ini membantu pelaku UMKM mengelola data usaha, mendaftar secara online, serta mempermudah verifikasi dan pemantauan oleh pihak pengelola.
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

  <!-- Added JS: toggle dropdowns + realtime filtering (tidak mengubah tampilan asli) -->
  <script>
    // Dropdown toggles
    const notifToggle = document.getElementById('notifToggle');
    const notifBox = document.getElementById('notifBox');
    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    function closeAllDropdowns(except) {
      if (except !== 'notif') notifBox.classList.add('dropdown-hidden');
      if (except !== 'profile') profileMenu.classList.add('dropdown-hidden');
    }

    notifToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      notifBox.classList.toggle('dropdown-hidden');
      profileMenu.classList.add('dropdown-hidden');
    });

    profileToggle.addEventListener('click', (e) => {
      e.stopPropagation();
      profileMenu.classList.toggle('dropdown-hidden');
      notifBox.classList.add('dropdown-hidden');
    });

    // close when clicking outside
    document.addEventListener('click', () => {
      notifBox.classList.add('dropdown-hidden');
      profileMenu.classList.add('dropdown-hidden');
    });

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

  </script>
</body>
</html>
