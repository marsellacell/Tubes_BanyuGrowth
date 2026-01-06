<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $information->judul }} | BanyuGrowth</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-800">
  <!-- Header sederhana -->
  <header class="w-full flex items-center justify-between px-6 py-4 shadow-md bg-white sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
      <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
    </div>
    <a href="{{ route('home') }}" class="text-green-700 hover:text-green-800 font-semibold flex items-center gap-1">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>
  </header>

  <main class="container mx-auto py-10 px-4">
    <!-- Informasi utama -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 mb-10">
      @if($information->banner)
      <img src="{{ Storage::url($information->banner) }}" alt="{{ $information->judul }}" class="w-full rounded-xl mb-6 shadow-lg">
      @endif
      <h2 class="font-bold text-3xl mb-4 text-green-700">{{ $information->judul }}</h2>
      <div class="text-gray-700 leading-relaxed whitespace-pre-line mb-4">
        {{ $information->konten }}
      </div>
      <p class="mt-6 text-gray-600 border-t pt-4">
        Diterbitkan pada: <strong>{{ $information->created_at->format('d F Y') }}</strong> oleh <strong>{{ $information->creator->nama_lengkap ?? 'Admin BanyuGrowth' }}</strong>
      </p>
    </div>

    <!-- Rekomendasi informasi lain -->
    @if($otherInformations->count() > 0)
    <section>
      <h3 class="font-bold text-lg mb-4">Informasi Lainnya</h3>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($otherInformations as $item)
        <a href="{{ route('information.show', $item->slug) }}" class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition transform hover:-translate-y-1">
          @if($item->banner)
          <img src="{{ Storage::url($item->banner) }}" alt="{{ $item->judul }}" class="w-full h-52 object-cover">
          @else
          <div class="w-full h-52 bg-gray-200 flex items-center justify-center">
            <i class="bi bi-image text-gray-400 text-4xl"></i>
          </div>
          @endif
          <div class="p-3">
            <h4 class="font-semibold text-gray-800">{{ $item->judul }}</h4>
            <p class="text-gray-500 text-sm mt-1">{{ Str::limit($item->konten, 80) }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $item->created_at->format('d M Y') }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </section>
    @endif
  </main>

  <footer class="text-center text-sm py-6 text-gray-500 border-t mt-10">
    © 2025 BanyuGrowth. Semua hak cipta dilindungi.
  </footer>
</body>
</html>
