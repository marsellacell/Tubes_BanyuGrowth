<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail UMKM | Admin BanyuGrowth</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
  @include('components.sweetalert')
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('components.admin-sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8 pt-20 lg:pt-8">
      <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail UMKM</h2>
            <p class="text-gray-600 mt-1">Informasi lengkap UMKM</p>
          </div>
          <a href="{{ route('admin.umkm.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
          {{ session('success') }}
        </div>
        @endif

        <!-- UMKM Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-6">
          <div class="flex items-start justify-between">
            <div class="flex items-start gap-6">
              <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-4xl">{{ strtoupper(substr($umkm->nama_usaha, 0, 1)) }}</span>
              </div>
              <div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $umkm->nama_usaha }}</h3>
                <p class="text-gray-600 mt-1"><i class="bi bi-person"></i> {{ $umkm->nama_lengkap }}</p>
                <p class="text-gray-600"><i class="bi bi-envelope"></i> {{ $umkm->email }}</p>
                <p class="text-gray-600"><i class="bi bi-telephone"></i> {{ $umkm->no_telepon }}</p>
                <div class="mt-3">
                  @if($umkm->status_verifikasi === 'approved')
                  <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                    <i class="bi bi-check-circle"></i> Approved
                  </span>
                  @elseif($umkm->status_verifikasi === 'pending')
                  <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-semibold">
                    <i class="bi bi-clock"></i> Pending
                  </span>
                  @else
                  <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                    <i class="bi bi-x-circle"></i> Rejected
                  </span>
                  @endif
                </div>
              </div>
            </div>

            <!-- Action Buttons -->
            @if($umkm->status_verifikasi === 'pending')
            <div class="flex gap-2">
              <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                  <i class="bi bi-check-lg"></i> Approve
                </button>
              </form>
              <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                  <i class="bi bi-x-lg"></i> Reject
                </button>
              </form>
            </div>
            @endif
          </div>

          <div class="mt-6 pt-6 border-t">
            <h4 class="font-semibold text-gray-700 mb-2"><i class="bi bi-geo-alt"></i> Alamat</h4>
            <p class="text-gray-600">{{ $umkm->alamat }}</p>
          </div>

          @if($umkm->verified_by)
          <div class="mt-4">
            <p class="text-sm text-gray-500">
              Diverifikasi oleh: <strong>{{ $umkm->verifiedBy->nama_lengkap ?? 'Admin' }}</strong>
              pada {{ $umkm->verified_at ? $umkm->verified_at->format('d M Y H:i') : '-' }}
            </p>
          </div>
          @endif
        </div>

        <!-- Products Section -->
        <div class="bg-white rounded-xl shadow-lg p-8">
          <h3 class="text-xl font-bold text-gray-800 mb-4">
            <i class="bi bi-box-seam"></i> Produk UMKM ({{ $umkm->products->count() }})
          </h3>

          @if($umkm->products->count() > 0)
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($umkm->products as $product)
            <div class="border rounded-lg overflow-hidden hover:shadow-lg transition">
              <img src="{{ $product->image ?? '/assets/img/default-product.jpg' }}" alt="{{ $product->nama_produk }}" class="w-full h-48 object-cover">
              <div class="p-4">
                <h4 class="font-semibold text-gray-800">{{ $product->nama_produk }}</h4>
                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($product->deskripsi, 60) }}</p>
                <p class="text-green-600 font-bold mt-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                  <span><i class="bi bi-eye"></i> {{ $product->jumlah_view }}</span>
                  <span><i class="bi bi-hand-thumbs-up"></i> {{ $product->jumlah_klik_beli }}</span>
                  <span class="px-2 py-1 {{ $product->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} rounded">
                    {{ ucfirst($product->status) }}
                  </span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @else
          <div class="text-center py-12">
            <i class="bi bi-inbox text-6xl text-gray-300"></i>
            <p class="text-gray-500 mt-4">Belum ada produk</p>
          </div>
          @endif
        </div>
      </div>
    </main>
  </div>
</body>
</html>
