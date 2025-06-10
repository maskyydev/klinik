<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Beranda' }}</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        .hidden {
            display: none;
        }
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

    <!-- Content -->
    <div id="content" class="flex flex-col w-full lg:flex-1">
        <!-- Navbar -->
        <nav class="bg-white p-4 animate__animated animate__fadeInDown">
            <div class="container mx-auto flex items-center justify-between">
                <button id="toggleSidebar" class="text-lg font-semibold focus:outline-none">
                    <!-- Toggle -->
                </button>
                <div class="flex items-center ml-auto">
                    <!-- Contoh logout jika kamu sudah setup route -->
                    {{-- <a href="{{ route('logout') }}" class="mx-2 text-red-600">Logout</a> --}}
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        @yield('content')
    </div>

    <!-- JavaScript to handle sidebar toggle -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const berandaContent = document.getElementById('content');
        const toggleSidebarButton = document.getElementById('toggleSidebar');
        const closeSidebarButton = document.getElementById('closeSidebar');
        const dropdownContent = document.getElementById('dropdownContent');

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

        function toggleDropdown() {
            if (dropdownContent.style.visibility === 'hidden' || !dropdownContent.style.visibility) {
                dropdownContent.style.visibility = 'visible';
                dropdownContent.style.opacity = 1;
                dropdownContent.style.display = 'block';
                dropdownContent.classList.remove('hidden');
                dropdownContent.classList.remove('animate__fadeOutLeft');
                dropdownContent.classList.add('animate__fadeInLeft');
            } else {
                dropdownContent.classList.remove('animate__fadeInLeft');
                dropdownContent.classList.add('animate__fadeOutLeft');

                setTimeout(() => {
                    dropdownContent.style.visibility = 'hidden';
                    dropdownContent.style.opacity = 0;
                    dropdownContent.style.display = 'none';
                    dropdownContent.classList.add('hidden');
                    dropdownContent.classList.remove('animate__fadeOutLeft');
                }, 500); // Adjust according to the CSS animation duration
            }
        }
    </script>

</body>
</html>
