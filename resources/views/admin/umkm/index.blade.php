<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Semua UMKM - BanyuGrowth Admin</title>
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
          <h2 class="text-2xl font-bold text-gray-800">Semua UMKM Terdaftar</h2>
          <p class="text-gray-600 mt-1">Kelola semua UMKM yang terdaftar di platform</p>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
          {{ session('success') }}
        </div>
        @endif

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow-md mb-6 p-4 flex gap-4">
          <a href="/admin/umkm" class="px-4 py-2 rounded-lg bg-green-600 text-white">Semua</a>
          <a href="/admin/umkm?status=approved" class="px-4 py-2 rounded-lg hover:bg-gray-100">Terverifikasi</a>
          <a href="/admin/umkm?status=pending" class="px-4 py-2 rounded-lg hover:bg-gray-100">Pending</a>
          <a href="/admin/umkm?status=rejected" class="px-4 py-2 rounded-lg hover:bg-gray-100">Ditolak</a>
        </div>

        <!-- UMKM Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <table class="w-full">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Usaha</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemilik</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Terdaftar</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              @forelse($umkmList as $umkm)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="font-semibold text-gray-800">{{ $umkm->nama_usaha }}</div>
                  <div class="text-sm text-gray-500">{{ $umkm->email }}</div>
                </td>
                <td class="px-6 py-4 text-gray-800">{{ $umkm->nama_lengkap }}</td>
                <td class="px-6 py-4 text-gray-600">{{ $umkm->no_telepon }}</td>
                <td class="px-6 py-4">
                  @if($umkm->status_verifikasi === 'approved')
                  <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    <i class="bi bi-check-circle"></i> Terverifikasi
                  </span>
                  @elseif($umkm->status_verifikasi === 'pending')
                  <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                    <i class="bi bi-clock"></i> Pending
                  </span>
                  @else
                  <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                    <i class="bi bi-x-circle"></i> Ditolak
                  </span>
                  @endif
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm">{{ $umkm->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4">
                  <a href="/admin/umkm/{{ $umkm->id }}" class="text-blue-600 hover:text-blue-800">
                    <i class="bi bi-eye"></i> Detail
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                  Belum ada UMKM terdaftar
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
    </main>
  </div>

</body>
</html>
