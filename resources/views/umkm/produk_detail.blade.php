<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $product->nama_produk }} | BanyuGrowth</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-800">
  <!-- HEADER -->
  <header class="w-full flex items-center justify-between px-6 py-4 shadow-md bg-white sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <img src="/assets/img/logo_banyugrowth.png" alt="logo" class="w-10">
      <h1 class="font-bold text-xl text-green-700">BanyuGrowth</h1>
    </div>
    <a href="{{ route('home') }}" class="text-green-700 hover:text-green-800 font-semibold flex items-center gap-1">
      <i class="bi bi-arrow-left"></i> Kembali ke Beranda
    </a>
  </header>

  <!-- DETAIL PRODUK -->
  <main class="container mx-auto py-10 px-4">
    <div class="grid md:grid-cols-2 gap-10 items-start bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
      <div>
        <img src="{{ $product->image ?? '/assets/img/default-product.jpg' }}" alt="{{ $product->nama_produk }}" class="w-full rounded-xl shadow-md object-cover" style="max-height: 500px;">
      </div>
      <div>
        <h2 class="font-bold text-2xl text-green-700 mb-2">{{ $product->nama_produk }}</h2>
        <p class="text-gray-600 mb-2">
          <i class="bi bi-shop"></i> UMKM: <strong>{{ $product->umkm->nama_usaha }}</strong>
        </p>
        <p class="text-gray-600 mb-4">
          <i class="bi bi-tag"></i> Kategori: <strong>{{ $product->category->nama_kategori ?? 'Lainnya' }}</strong>
        </p>
        @if($product->lokasi)
        <p class="text-gray-600 mb-4">
          <i class="bi bi-geo-alt"></i> Lokasi: <strong>{{ $product->lokasi }}</strong>
        </p>
        @endif
        <p class="text-lg text-gray-800 mb-4 leading-relaxed">
          {{ $product->deskripsi }}
        </p>
        <p class="text-green-700 font-bold text-2xl mb-4">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>

        <div class="flex gap-4 items-center mb-4 text-sm text-gray-600">
          <span title="Views"><i class="bi bi-eye"></i> {{ $product->jumlah_view ?? 0 }}</span>
          <span title="Purchases"><i class="bi bi-cart"></i> {{ $product->jumlah_klik_beli ?? 0 }}</span>
          <button class="like-button flex items-center gap-1 hover:scale-110 transition" data-product-id="{{ $product->id }}" title="Like this product">
            <i class="bi bi-heart"></i> <span class="like-count">{{ $product->jumlah_like ?? 0 }}</span>
          </button>
        </div>

        <form action="{{ route('products.buy', $product->id) }}" method="POST">
          @csrf
          <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition font-semibold">
            <i class="bi bi-whatsapp"></i> Pesan via WhatsApp
          </button>
        </form>
        {{--
        <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
          <h4 class="font-semibold text-gray-700 mb-2">Informasi Kontak</h4>
          <p class="text-sm text-gray-600"><i class="bi bi-telephone"></i> {{ $product->umkm->no_telepon }}</p>
        <p class="text-sm text-gray-600"><i class="bi bi-envelope"></i> {{ $product->umkm->email }}</p>
        @if($product->umkm->alamat)
        <p class="text-sm text-gray-600"><i class="bi bi-geo-alt"></i> {{ $product->umkm->alamat }}</p>
        @endif
      </div> --}}
    </div>
    </div>

    <!-- PRODUK LAIN DARI UMKM YANG SAMA -->
    @php
    $relatedProducts = \App\Models\Product::where('umkm_id', $product->umkm_id)
    ->where('id', '!=', $product->id)
    ->where('status', 'active')
    ->take(4)
    ->get();
    @endphp

    @if($relatedProducts->count() > 0)
    <section class="mt-10">
      <h3 class="font-bold text-xl mb-5">Produk Lain dari {{ $product->umkm->nama_usaha }}</h3>
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
        @foreach($relatedProducts as $related)
        <a href="{{ route('products.show', $related->id) }}" class="bg-white border rounded-xl shadow hover:shadow-lg transition overflow-hidden block">
          <img src="{{ $related->image ?? '/assets/img/default-product.jpg' }}" alt="{{ $related->nama_produk }}" class="w-full h-40 object-cover">
          <div class="p-3">
            <p class="font-medium text-gray-700 text-sm mb-1">{{ Str::limit($related->nama_produk, 30) }}</p>
            <p class="text-green-600 font-semibold text-sm">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </section>
    @endif
  </main>

  <!-- FOOTER -->
  <footer class="text-center text-sm py-6 text-gray-500 border-t mt-10">
    © 2025 BanyuGrowth. Semua hak cipta dilindungi.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    .like-button {
      background: none;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .like-button:hover {
      transform: scale(1.1);
    }

    .like-button.liked i {
      color: #ef4444;
    }

  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      const likeButton = document.querySelector('.like-button');

      if (likeButton) {
        likeButton.addEventListener('click', function(e) {
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
                this.style.transform = 'scale(1.3)';
                setTimeout(() => {
                  this.style.transform = 'scale(1)';
                }, 200);
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
        });
      }
    });

  </script>
</body>
</html>
