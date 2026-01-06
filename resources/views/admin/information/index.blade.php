<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Informasi - Admin Panel</title>
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
        <div class="flex justify-between items-center mb-6">
          <div>
            <h2 class="text-2xl font-bold text-gray-800">
              <i class="bi bi-newspaper text-blue-500"></i> Kelola Informasi
            </h2>
            <p class="text-gray-600 mt-1">Kelola postingan informasi yang tampil di beranda</p>
          </div>
          <a href="{{ route('admin.information.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition font-semibold shadow-lg flex items-center gap-2">
            <i class="bi bi-plus-circle"></i>
            Tambah Informasi
          </a>
        </div>

        <!-- Informations Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                <tr>
                  <th class="px-6 py-4 text-left text-sm font-semibold">BANNER</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">JUDUL</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">DIBUAT OLEH</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">TANGGAL</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">STATUS</th>
                  <th class="px-6 py-4 text-left text-sm font-semibold">AKSI</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                @forelse($informations as $info)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-6 py-4">
                    @if($info->banner)
                    <img src="{{ Storage::url($info->banner) }}" alt="{{ $info->judul }}" class="w-24 h-16 object-cover rounded-lg shadow">
                    @else
                    <div class="w-24 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                      <i class="bi bi-image text-gray-400 text-xl"></i>
                    </div>
                    @endif
                  </td>
                  <td class="px-6 py-4">
                    <div class="font-semibold text-gray-800">{{ $info->judul }}</div>
                    <div class="text-sm text-gray-500">{{ Str::limit($info->konten, 80) }}</div>
                  </td>
                  <td class="px-6 py-4">
                    <span class="text-gray-700">{{ $info->creator->nama_lengkap ?? 'Admin' }}</span>
                  </td>
                  <td class="px-6 py-4">
                    <div class="text-gray-700">{{ $info->created_at->format('d M Y') }}</div>
                    <div class="text-xs text-gray-500">{{ $info->created_at->format('H:i') }}</div>
                  </td>
                  <td class="px-6 py-4">
                    @if($info->is_published)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                      <i class="bi bi-check-circle"></i> Published
                    </span>
                    @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                      <i class="bi bi-x-circle"></i> Draft
                    </span>
                    @endif
                  </td>
                  <td class="px-6 py-4">
                    <div class="flex gap-2">
                      <a href="{{ route('admin.information.edit', $info->id) }}" class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded transition" title="Edit">
                        <i class="bi bi-pencil-square text-lg"></i>
                      </a>
                      <form action="{{ route('admin.information.togglePublish', $info->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-orange-600 hover:text-orange-800 p-2 hover:bg-orange-50 rounded transition" title="Toggle Publish">
                          <i class="bi bi-{{ $info->is_published ? 'eye-slash' : 'eye' }} text-lg"></i>
                        </button>
                      </form>
                      <form action="{{ route('admin.information.destroy', $info->id) }}" method="POST" id="delete-form-{{ $info->id }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete('delete-form-{{ $info->id }}')" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded transition" title="Hapus">
                          <i class="bi bi-trash text-lg"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    <i class="bi bi-inbox text-6xl text-gray-300"></i>
                    <p class="mt-4">Belum ada informasi. Tambahkan informasi pertama!</p>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
