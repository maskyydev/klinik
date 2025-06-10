<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Beranda Admin')</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body class="bg-gray-100 font-sans">

  <!-- Wrapper -->
  <div class="min-h-screen flex flex-col lg:flex-row">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-full lg:w-64 bg-white p-4 hidden lg:flex flex-col shadow animate__animated animate__fadeInLeft z-30 min-h-screen">
      <h1 class="text-xl font-bold mb-4">Menu</h1>
      <nav class="space-y-2">
        <a href="{{ url('/home') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Dashboard</a>
        <a href="{{ url('pasien/antrian') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Data Pendaftar</a>
        <a href="{{ url('/detail') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Detail Diagnosa Pasien</a>
        <div id="transaksiDropdown" class="relative">
            <a href="#" onclick="toggleDropdown()" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300 animate__animated animate__fadeInLeft">
                <span>Transaksi</span>
                <b><span id="arrowIcon">&gt;</span></b> <!-- Panah default ke kanan -->
            </a>
            <div id="dropdownContent" class="hidden ml-5 absolute left-0 top-8 border-gray-300 p-2 rounded animate__animated animate__fadeInLeft">
                <a href="{{ url('/obat') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Detail Obat</a>
                <a href="{{ url('/riwayat') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Riwayat Obat Terjual</a>
                <a href="{{ url('/obatmasuk') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Riwayat Obat Masuk</a>
                <a href="{{ url('/riwayatpasien') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Riwayat Data Pendaftar</a>
                <a href="{{ url('/riwayatpembayaran') }}" class="block pl-4 pr-2 py-2 text-sm font-medium text-black hover:bg-gray-200 transition duration-300">Riwayat Pembayaran</a>
            </div>
        </div>
      </nav>
      <!-- Tombol tutup sidebar untuk mobile -->
      <button id="closeSidebar" class="absolute top-2 right-2 lg:hidden text-gray-600">✕</button>
    </aside>

    <!-- Konten Utama -->
    <div class="flex-1 bg-white flex flex-col min-h-screen">

      <!-- Navbar -->
      <nav class="bg-white shadow p-4 flex items-center justify-between animate__animated animate__fadeInDown z-30">
        <button id="toggleSidebar" class="lg:hidden text-gray-700 text-xl">&#9776;</button>
        <div class="flex-1 text-center lg:text-left">
          <h2 class="text-lg font-semibold text-gray-700">@yield('title', 'Beranda Admin')</h2>
        </div>
        <div class="flex justify-end">
          <a href="{{ url('/logout') }}" class="text-red-500 hover:underline">Logout</a>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="flex-grow p-6 bg-gray-100">
        @yield('content')
      </main>

    </div>
  </div>

  <!-- Script Dropdown & Sidebar -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const toggleSidebarBtn = document.getElementById('toggleSidebar');
    const closeSidebarBtn = document.getElementById('closeSidebar');
    const dropdownContent = document.getElementById('dropdownContent');

    toggleSidebarBtn?.addEventListener('click', () => {
      sidebar.classList.toggle('hidden');
    });

    closeSidebarBtn?.addEventListener('click', () => {
      sidebar.classList.add('hidden');
    });

    function toggleDropdown() {
        const dropdown = document.getElementById("dropdownContent");
        const arrowIcon = document.getElementById("arrowIcon");

        dropdown.classList.toggle("hidden");

        if (dropdown.classList.contains("hidden")) {
            arrowIcon.innerHTML = "&gt;"; // Panah ke kanan
        } else {
            arrowIcon.innerHTML = "&#709;"; // Panah ke bawah (˅)
        }
    }
  </script>

</body>
</html>
