<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $produk['nama'] }} | BanyuGrowth</title>

  <!-- Tailwind & Bootstrap -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
    }

    .product-image {
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-back {
      background-color: #22c55e;
      color: white;
      padding: 8px 16px;
      border-radius: 9999px;
      transition: .3s;
    }

    .btn-back:hover {
      background-color: #16a34a;
    }

    .payment-logos img {
      height: 35px;
    }

    /* bikin logo bank kecil dan sejajar */

  </style>
</head>
<body>

  <!-- HEADER -->
  <header class="w-full flex items-center justify-between px-6 py-4 shadow-md bg-white sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
      <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
    </div>
    <a href="{{ route('home') }}" class="btn-back flex items-center gap-2">
      <i class="bi bi-arrow-left"></i> Kembali
    </a>
  </header>

  <!-- DETAIL PRODUK -->
  <section class="container mx-auto py-12 px-6">
    <div class="grid md:grid-cols-2 gap-10 items-center">
      <div class="product-image">
        <img src="{{ $produk['image'] }}" alt="{{ $produk['nama'] }}" class="w-full h-[400px] object-cover">
      </div>

      <div>
        <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $produk['nama'] }}</h2>
        <p class="text-sm text-gray-500 mb-4">oleh {{ $produk['umkm'] }}</p>
        <p class="text-green-600 font-bold text-2xl mb-3">Rp{{ $produk['harga'] }}</p>
        <p class="text-gray-600 leading-relaxed mb-5">{{ $produk['deskripsi'] }}</p>

        <p class="text-sm text-gray-700"><i class="bi bi-geo-alt text-green-600"></i> {{ $produk['lokasi'] }}</p>
        <p class="text-sm text-gray-700 mt-2"><i class="bi bi-star-fill text-yellow-500"></i> {{ $produk['rating'] }} / 5</p>

        <button class="mt-5 px-6 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition">
          Beli Sekarang
        </button>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="mt-10 bg-gray-100 py-10 border-t">
    <div class="container mx-auto grid md:grid-cols-3 gap-8 text-center md:text-left">
      <div>
        <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
          <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
          <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
        </div>
        <p class="text-sm text-gray-700 text-justify">
          Banyu Growth adalah sebuah website yang dirancang untuk mempermudah proses pendaftaran dan pendataan UMKM Kabupaten Banyumas yang telah bergabung dalam Aspikmas. Platform ini membantu pelaku UMKM mengelola data usaha, mendaftar secara online, serta mempermudah verifikasi dan pemantauan oleh pihak pengelola.
        </p>
      </div>

      <div>
        <h3 class="font-semibold text-green-700 mb-3">Informasi</h3>
        <p><a href="#faqAccordion" class="text-gray-700 hover:text-green-600">FAQ (Tanya Jawab)</a></p>
      </div>

      <div>
        <h3 class="font-semibold text-green-700 mb-3">Hubungi Kami</h3>
        <div class="flex justify-center items-center">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.3998196383886!2d109.235393573637!3d-7.420926892589536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655f5c88b415e1%3A0x12dc7703a7249995!2sGaleri%20UKM%20Banyumas%20Raya!5e0!3m2!1sid!2sid!4v1762241656751!5m2!1sid!2sid" width="300" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <p class="text-sm text-gray-700">Sitapen, Purwanegara, Kec. Purwokerto Utara,<br>Kabupaten Banyumas, Jawa Tengah 53116</p>
        <p class="text-sm mt-2 text-gray-700">09.00 - 17.00 | Senin - Sabtu</p>
        <div class="flex justify-center items-center gap-3 mt-3">
          <a href="https://facebook.com/aspikmas.banyumas" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/aspikmart" target="_blank" class="text-pink-600 hover:text-pink-800 text-2xl"><i class="bi bi-instagram"></i></a>
          <a href="https://youtube.com/@aspikmasbaturraden" target="_blank" class="text-red-600 hover:text-red-800 text-2xl"><i class="bi bi-youtube"></i></a>
        </div>
      </div>
    </div>

    <div class="container mx-auto text-center mt-8">
      <p class="font-bold text-gray-800">Metode Pembayaran:</p>
      <div class="flex justify-center items-center gap-8 mt-3 payment-logos flex-wrap md:flex-nowrap">
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

</body>
</html>
