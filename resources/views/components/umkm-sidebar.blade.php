<!-- Mobile Menu Toggle Button -->
<button id="mobileMenuToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg hover:bg-green-700 transition">
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
      <i class="bi bi-shop-window text-3xl text-green-600"></i>
      <h1 class="font-bold text-xl text-gray-800">Panel UMKM</h1>
    </div>

    <nav class="space-y-2">
      <a href="/umkm/dashboard" class="flex items-center gap-3 px-4 py-2 {{ request()->is('umkm/dashboard') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }} rounded-lg">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
      </a>
      <a href="/umkm/products" class="flex items-center gap-3 px-4 py-2 {{ request()->is('umkm/products') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }} rounded-lg">
        <i class="bi bi-box-seam"></i>
        <span>Produk Saya</span>
      </a>
      <a href="/umkm/products/create" class="flex items-center gap-3 px-4 py-2 {{ request()->is('umkm/products/create') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }} rounded-lg">
        <i class="bi bi-plus-circle"></i>
        <span>Tambah Produk</span>
      </a>
      <a href="/umkm/statistics" class="flex items-center gap-3 px-4 py-2 {{ request()->is('umkm/statistics') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }} rounded-lg">
        <i class="bi bi-graph-up"></i>
        <span>Statistik</span>
      </a>
      <a href="/umkm/profile/edit" class="flex items-center gap-3 px-4 py-2 {{ request()->is('umkm/profile/edit') ? 'bg-green-100 text-green-700' : 'text-gray-700 hover:bg-green-50' }} rounded-lg">
        <i class="bi bi-person-circle"></i>
        <span>Edit Profile</span>
      </a>
      <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2 text-gray-700 hover:bg-green-50 rounded-lg">
        <i class="bi bi-house"></i>
        <span>Ke Beranda</span>
      </a>
      <a href="#" onclick="confirmLogout('/umkm/logout')" class="flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg mt-8">
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
