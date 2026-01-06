<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ | BanyuGrowth</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <!-- Google Fonts - Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8fafc;
    }

    /* Hero Section */
    .faq-hero {
      background: linear-gradient(135deg, #0ea5e9, #10b981);
      color: white;
      text-align: center;
      padding: 80px 20px 60px;
      border-bottom-left-radius: 40px;
      border-bottom-right-radius: 40px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    /* Accordion Style */
    .accordion-button {
      font-weight: 600;
      color: #065f46;
      background: #f0fdf4;
    }

    .accordion-button:not(.collapsed) {
      background-color: #a7f3d0;
      color: #064e3b;
      box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .125);
    }

    .accordion-item {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .accordion-body {
      background-color: #ffffff;
      color: #374151;
      line-height: 1.6;
    }

    /* Fix untuk bentrok Tailwind-Bootstrap (dari home) */
    .accordion-button:focus {
      box-shadow: none;
    }

    .accordion-collapse {
      /* hapus efek height animation Bootstrap yang bentrok */
      transition: none !important;
    }

    .accordion-body {
      display: block !important;
      visibility: visible !important;
      opacity: 1 !important;
    }

    /* WhatsApp Button */
    .wa-btn {
      transition: all 0.3s ease;
      box-shadow: 0 6px 18px rgba(22, 163, 74, 0.3);
    }

    .wa-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 24px rgba(22, 163, 74, 0.4);
    }

    /* Footer logo payment fix */
    footer img {
      height: 30px;
      object-fit: contain;
    }

  </style>
</head>

<body>

  <!-- HEADER -->
  <header class="faq-hero">
    <div class="container mx-auto">
      <img src="/assets/img/logo_banyugrowth.png" alt="Logo" class="w-20 mx-auto mb-4 drop-shadow-md">
      <h1 class="text-3xl md:text-4xl font-bold mb-2">Pertanyaan Umum (FAQ)</h1>
      <p class="text-white/90 max-w-2xl mx-auto text-lg">
        Temukan jawaban seputar pendaftaran, pengelolaan, dan layanan UMKM di BanyuGrowth.
      </p>
      <a href="{{ route('home') }}" class="mt-5 inline-flex items-center gap-2 bg-white text-green-700 font-semibold py-2 px-4 rounded-full shadow hover:bg-green-100 transition">
        <i class="bi bi-arrow-left-circle"></i> Kembali ke Beranda
      </a>
    </div>
  </header>

  <!-- PERTANYAAN UMUM -->
  <section class="mt-12 container mx-auto px-4 md:px-20">
    <div class="text-center mb-8">
      <h2 class="text-2xl font-bold text-green-700">Pertanyaan Umum</h2>
      <p class="text-gray-600 mt-2">Berikut beberapa pertanyaan yang sering diajukan oleh pelaku UMKM.</p>
    </div>

    <div class="accordion space-y-3" id="faqAccordion">

      <!-- Item 1 -->
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading1">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            Bagaimana cara mengubah data usaha setelah terdaftar?
          </button>
        </h2>
        <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Setelah mendaftarkan UMKM Anda di BanyuGrowth dan akun telah diverifikasi oleh administrator, Anda dapat mengubah data usaha kapan saja melalui menu profil.
            <br><br>
            <strong>Langkah-langkah:</strong>
            <ul class="list-disc pl-5 mt-2">
              <li>Login menggunakan akun UMKM.</li>
              <li>Akses halaman profil usaha.</li>
              <li>Klik tombol "Edit".</li>
              <li>Ubah informasi yang diperlukan.</li>
              <li>Klik "Simpan".</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="accordion-item mt-2">
        <h2 class="accordion-header" id="heading2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
            Apa saja data yang perlu disiapkan saat mendaftar UMKM?
          </button>
        </h2>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Siapkan informasi berikut sebelum mendaftar:
            <ul class="list-disc pl-5 mt-2">
              <li><strong>Identitas Pemilik Usaha:</strong> Nama, email, nomor telepon aktif.</li>
              <li><strong>Akun Pengguna:</strong> Username dan password yang aman.</li>
              <li><strong>Informasi Usaha:</strong> Nama UMKM, kategori, alamat, dan deskripsi singkat.</li>
              <li><strong>Dokumen Legalitas:</strong> Surat izin usaha (PDF/JPG).</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="accordion-item mt-2">
        <h2 class="accordion-header" id="heading3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
            Keuntungan mendaftarkan UMKM dengan BanyuGrowth
          </button>
        </h2>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Dengan BanyuGrowth, UMKM Anda akan mendapatkan manfaat seperti:
            <ul class="list-disc pl-5 mt-2">
              <li>Kemudahan pengelolaan data usaha</li>
              <li>Pencatatan data terstruktur</li>
              <li>Akses laporan dan statistik perkembangan</li>
              <li>Peningkatan visibilitas digital</li>
              <li>Keamanan dan transparansi data</li>
              <li>Dukungan integrasi dengan layanan eksternal</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Item 4 -->
      <div class="accordion-item mt-2">
        <h2 class="accordion-header" id="heading4">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
            Cara Daftar/Registrasi di Pasar Digital UMKM
          </button>
        </h2>
        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Untuk mendaftar di BanyuGrowth:
            <ol class="list-decimal pl-5 mt-2">
              <li>Kunjungi situs resmi BanyuGrowth.</li>
              <li>Klik "Daftar sebagai UMKM".</li>
              <li>Isi formulir pendaftaran lengkap.</li>
              <li>Unggah dokumen legalitas usaha.</li>
              <li>Klik "Kirim" dan tunggu verifikasi admin.</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA WhatsApp -->
    <div class="text-center mt-12">
      <p class="text-gray-700 mb-3">Masih butuh bantuan lebih lanjut?</p>
      <a href="https://wa.me/6282328661410" target="_blank" class="inline-flex items-center gap-3 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-full wa-btn">
        <i class="bi bi-whatsapp text-2xl"></i> Hubungi Kami via WhatsApp
      </a>
      <p class="text-xs text-gray-500 mt-2">Layanan: Senin–Sabtu, 09.00–17.00</p>
    </div>
  </section>

  <!-- FOOTER (copy dari home, ukuran payment logo fix) -->
  <footer class="mt-16 bg-gray-100 py-10 border-t">
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
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.3998196383886!2d109.235393573637!3d-7.420926892589536!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e655f5c88b415e1%3A0x12dc7703a7249995!2sGaleri%20UKM%20Banyumas%20Raya!5e0!3m2!1sid!2sid!4v1762241656751!5m2!1sid!2sid" width="300" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <p class="text-sm text-gray-700">Sitapen, Purwanegara, Purwokerto Utara, Banyumas</p>
        <p class="text-sm mt-2 text-gray-700">09.00 - 17.00 | Senin - Sabtu</p>
        <div class="flex justify-center items-center gap-3 mt-3">
          <a href="https://facebook.com/aspikmas.banyumas" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/aspikmart?igsh=N243Nmp2bHVuazNw" target="_blank" class="text-pink-600 hover:text-pink-800 text-2xl"><i class="bi bi-instagram"></i></a>
          <a href="https://youtube.com/@aspikmasbaturraden?si=x262q0Xf6R7W_LKN" target="_blank" class="text-red-600 hover:text-red-800 text-2xl"><i class="bi bi-youtube"></i></a>
        </div>
        <p class="text-sm mt-2 text-gray-500">Layanan Pengaduan Pengguna</p>
      </div>
    </div>

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

</body>
</html>
