@extends('layoutt')

@section('content')
<!-- Modal Notifikasi Pop-up -->
@if (session('welcome'))
    <style>
        @keyframes popCheck {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
                opacity: 1;
            }
            100% {
                transform: scale(1);
            }
        }

        .animate-check {
            animation: popCheck 0.6s ease-out;
        }
    </style>

    <div id="welcomeModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50">
        <div class="bg-white p-6 rounded-md shadow-md max-w-sm w-full relative text-center">
            <!-- Animasi Centang -->
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-green-500 animate-check" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-xl font-semibold mb-2">Login Berhasil!!</h2>
            <p class="text-gray-700">Selamat datang, {{ session('welcome') }}!</p><br><br><br>

            <button id="closeModal" class="absolute bottom-4 right-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md mt-6">
                Lanjut
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('welcomeModal');
            var closeModal = document.getElementById('closeModal');
            var mainContent = document.querySelector('main');

            // Sembunyikan konten utama
            mainContent.style.visibility = 'hidden';

            // Tampilkan modal
            modal.classList.remove('hidden');

            // Event listener untuk menutup modal
            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
                mainContent.style.visibility = 'visible'; // Tampilkan konten kembali
            });
        });
    </script>
@endif

<!-- Konten Beranda -->
<main class="flex-1 p-6 animate__animated animate__zoomIn">
    <div class="bg-white rounded-lg p-8 shadow-md">
        <h1 class="text-3xl font-semibold mb-4 text-blue-500">Selamat Datang di Klinik Dr. Zhulfi</h1>
        <p class="text-gray-700 leading-relaxed">
            Kami menyediakan pelayanan kesehatan yang terbaik untuk Anda. Tim profesional kami berkomitmen untuk memberikan layanan kesehatan berkualitas tinggi kepada masyarakat. Dengan perawatan yang terbaik, kami hadir untuk menjaga kesehatan Anda.
        </p>

        <div class="mt-6">
            <h2 class="text-xl font-semibold mb-2 text-blue-500">Layanan Kami</h2>
            <ul class="list-disc list-inside text-gray-700">
                <li>Pemeriksaan kesehatan umum</li>
                <li>Konsultasi dokter spesialis</li>
                <li>Perawatan gigi</li>
                <!-- Tambahkan layanan lainnya sesuai kebutuhan -->
            </ul>
        </div>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-2 text-blue-500">Jam Operasional</h2>
                <p class="text-gray-700">Senin - Jumat: 08.00 - 18.00</p>
                <p class="text-gray-700">Sabtu: 09.00 - 13.00</p>
                <!-- Tambahkan informasi jam operasional lainnya jika diperlukan -->
            </div>
        </div><br>

        <div>
            <h2 class="text-xl font-semibold mb-2 text-blue-500">Lokasi Kami</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d247.257882314738!2d112.32953623514803!3d-7.451296911236274!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e781401c713a245%3A0xc0166e8a9c0af912!2sG8XH%2BFW4%2C%20Keboan%2C%20Kec.%20Ngusikan%2C%20Kabupaten%20Jombang%2C%20Jawa%20Timur%2061454%2C%20Indonesia!5e0!3m2!1sen!2sus!4v1721820947103!5m2!1sen!2sus"
                width="600"
                height="450"
                style="border:0; width: 100%; height: 100%;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</main>

<footer class="text-center text-gray-500 text-sm mt-4">
    <h1>Dr. Ahmad Dzulfikar Haq</h1>
</footer>
@endsection
