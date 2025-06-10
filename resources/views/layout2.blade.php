<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Beranda' }}</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        .hidden { display: none; }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .pagination li {
            margin: 0 0.5rem;
        }
        .pagination a {
            display: block;
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            text-decoration: none;
            color: #3182ce;
        }
        .pagination a:hover {
            background-color: #ebf8ff;
        }
        .pagination .active a {
            background-color: #3182ce;
            color: #ffffff;
        }
        .pagination .disabled a {
            background-color: #edf2f7;
            color: #cbd5e0;
        }
    </style>
</head>
<body class="font-sans bg-gray-100 flex flex-col lg:flex-row">

    <!-- Main Content -->
    <div id="content" class="flex flex-col w-full lg:flex-1">
        <!-- Navbar -->
        <nav class="bg-white p-4 animate__animated animate__fadeInDown">
            <div class="container mx-auto flex items-center justify-between">
                {{-- Uncomment jika ingin menggunakan tombol sidebar --}}
                {{-- <button id="toggleSidebar" class="text-lg font-semibold focus:outline-none">
                    <span class="text-gray-700">&#9776; Menu</span>
                </button> --}}
                <div class="flex items-center ml-auto">
                    <a href="{{ url('/login') }}" class="mx-2 text-blue-700">Login</a>
                    <a href="#" class="mx-2" onclick="openAboutModal()">About</a>
                </div>
            </div>
        </nav>

        {{-- Tempat konten halaman --}}
        @yield('content')
    </div>

    <!-- Modal About -->
    <div id="aboutModal" class="fixed inset-0 overflow-y-auto hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="bg-white rounded-lg p-8 max-w-6xl w-full relative animate__animated animate__zoomIn z-50">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-semibold">About Us</h2>
                    <button onclick="closeAboutModal()" class="text-gray-600 hover:text-gray-800 focus:outline-none text-2xl">
                        &times;
                    </button>
                </div>
                <div class="p-4 rounded-md space-y-4 text-gray-700 text-justify">
                    <p>Selamat datang di Aplikasi Klinik kami! Di sini, kami berkomitmen untuk menyediakan layanan kesehatan berkualitas dan memastikan kenyamanan serta keamanan setiap pasien...</p>
                    <p>Visi kami adalah menjadi pusat kesehatan terdepan yang memberikan solusi lengkap untuk kebutuhan kesehatan Anda...</p>
                    <p>Kami bangga memiliki tim profesional yang terdiri dari dokter, perawat, dan staf medis berdedikasi...</p>
                    <p>Selain memberikan perawatan kesehatan yang unggul, kami juga peduli terhadap lingkungan...</p>
                    <p>Terima kasih telah memilih layanan kesehatan kami. Dukungan Anda memotivasi kami untuk terus berkembang dan memberikan yang terbaik...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle sidebar toggle -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const berandaContent = document.getElementById('content');
        const toggleSidebarButton = document.getElementById('toggleSidebar');
        const closeSidebarButton = document.getElementById('closeSidebar');

        toggleSidebarButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            berandaContent.classList.toggle('lg:ml-64'); // Sesuaikan dengan lebar sidebar

            // Tambahkan logika untuk menyembunyikan konten Beranda
            if (berandaContent.classList.contains('hidden')) {
                berandaContent.classList.remove('hidden');
            } else {
                berandaContent.classList.add('hidden');
            }
        });

        closeSidebarButton.addEventListener('click', () => {
            sidebar.classList.add('hidden');
            berandaContent.classList.remove('lg:ml-64');

            // Tambahkan logika untuk menampilkan kembali konten Beranda
            if (berandaContent.classList.contains('hidden')) {
                berandaContent.classList.remove('hidden');
            }
        });

        function openAboutModal() {
            document.getElementById('aboutModal').classList.remove('hidden');
        }

        function closeAboutModal() {
            document.getElementById('aboutModal').classList.add('hidden');
        }
    </script>

</body>
</html>
