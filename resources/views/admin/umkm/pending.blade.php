<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UMKM Pending - BanyuGrowth Admin</title>
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
      <div class="max-w-7xl mx-auto">
        <div class="mb-6">
          <h2 class="text-2xl font-bold text-gray-800">UMKM Menunggu Verifikasi</h2>
          <p class="text-gray-600 mt-1">Daftar UMKM yang menunggu persetujuan</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
          {{ session('success') }}
        </div>
        @endif

        @if($pendingList->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
          <i class="bi bi-check-circle text-green-500 text-6xl mb-4"></i>
          <p class="text-gray-600 text-lg">Tidak ada UMKM yang menunggu verifikasi</p>
        </div>
        @else
        <div class="grid gap-6">
          @foreach($pendingList as $umkm)
          <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-800">{{ $umkm->nama_usaha }}</h3>
                <p class="text-gray-600 mt-2">
                  <i class="bi bi-person mr-2"></i>
                  <strong>Pemilik:</strong> {{ $umkm->nama_lengkap }}
                </p>
                <p class="text-gray-600 mt-1">
                  <i class="bi bi-envelope mr-2"></i>
                  {{ $umkm->email }}
                </p>
                <p class="text-gray-600 mt-1">
                  <i class="bi bi-telephone mr-2"></i>
                  {{ $umkm->no_telepon }}
                </p>
                <p class="text-gray-600 mt-1">
                  <i class="bi bi-geo-alt mr-2"></i>
                  {{ $umkm->alamat }}
                </p>
                <p class="text-sm text-gray-500 mt-3">
                  <i class="bi bi-calendar mr-2"></i>
                  Terdaftar: {{ $umkm->created_at->format('d M Y, H:i') }}
                </p>
              </div>

              <div class="flex flex-col gap-2 ml-6">
                <form action="/admin/umkm/{{ $umkm->id }}/approve" method="POST" id="approve-form-{{ $umkm->id }}">
                  @csrf
                  <button type="button" onclick="confirmApprove('approve-form-{{ $umkm->id }}')" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="bi bi-check-circle"></i>
                    Setujui
                  </button>
                </form>

                <form action="/admin/umkm/{{ $umkm->id }}/reject" method="POST" id="reject-form-{{ $umkm->id }}">
                  @csrf
                  <button type="button" onclick="confirmReject('reject-form-{{ $umkm->id }}')" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition flex items-center gap-2">
                    <i class="bi bi-x-circle"></i>
                    Tolak
                  </button>
                </form>

                <a href="/admin/umkm/{{ $umkm->id }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition text-center">
                  <i class="bi bi-eye"></i>
                  Detail
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        @endif
    </main>
  </div>

</body>
</html>
