<!-- Mobile Menu Toggle Button -->
<button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-blue-600 text-white p-3 rounded-lg shadow-lg hover:bg-blue-700 transition">
  <i class="bi bi-list text-2xl"></i>
</button>

<!-- Overlay for mobile -->
<div id="sidebarOverlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="fixed lg:relative inset-y-0 left-0 w-64 bg-white shadow-lg z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out min-h-screen overflow-y-auto">
  <div class="p-6">
    <!-- Close button for mobile -->
    <button id="closeSidebar" class="lg:hidden absolute top-4 right-4 text-gray-600 hover:text-gray-800">
      <i class="bi bi-x-lg text-2xl"></i>
    </button>

    <div class="flex items-center gap-2 mb-8">
      <i class="bi bi-shield-check text-3xl text-blue-600"></i>
      <h1 class="font-bold text-xl text-gray-800">Admin Panel</h1>
    </div>

    <nav class="space-y-2">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-lg">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
      <a href="{{ route('admin.umkm.pending') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.umkm.pending') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-lg">
        <i class="bi bi-hourglass-split"></i>
        <span>UMKM Pending</span>
      </a>
      <a href="{{ route('admin.umkm.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.umkm.index') || request()->routeIs('admin.umkm.show') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-lg">
        <i class="bi bi-shop"></i>
        <span>Semua UMKM</span>
      </a>
      <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.products.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-lg">
        <i class="bi bi-box-seam"></i>
        <span>Kelola Produk</span>
      </a>
      <a href="{{ route('admin.information.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.information.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-lg">
        <i class="bi bi-newspaper"></i>
        <span>Kelola Informasi</span>
      </a>
      <a href="{{ route('admin.statistics.index') }}" class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('admin.statistics.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-blue-50' }} rounded-lg">
        <i class="bi bi-graph-up"></i>
        <span>Statistik</span>
      </a>
      <a href="#" onclick="confirmLogout('{{ route('admin.logout') }}')" class="flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg mt-8">
        <i class="bi bi-box-arrow-right"></i>
        <span>Logout</span>
      </a>
    </nav>
  </div>
</aside>

<script>
  // Mobile menu toggle
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const sidebar = document.getElementById('sidebar');
  const sidebarOverlay = document.getElementById('sidebarOverlay');
  const closeSidebar = document.getElementById('closeSidebar');

  function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    sidebarOverlay.classList.remove('hidden');
  }

  function closeSidebarMenu() {
    sidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.add('hidden');
  }

  mobileMenuToggle ? .addEventListener('click', openSidebar);
  closeSidebar ? .addEventListener('click', closeSidebarMenu);
  sidebarOverlay ? .addEventListener('click', closeSidebarMenu);

</script>
