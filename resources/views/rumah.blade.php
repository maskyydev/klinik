@extends('layout2')

@section('content')
<div class="min-h-screen bg-gray-100 p-6">
    <!-- Hero Section -->
    <div class="bg-blue-600 text-white p-8 rounded-lg shadow-lg mb-6">
        <h1 class="text-3xl font-bold mb-2">Selamat Datang di Klinik Dr. Zhulfi</h1>
        <p class="text-lg">Temukan informasi terbaru dan artikel kesehatan di sini.</p>
    </div>

    <!-- Blog Posts -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Post 1 -->
        <div class="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 duration-300">
            <img src="{{ asset('img/diabetes.jpg') }}" alt="Artikel 1" class="w-full h-40 object-cover rounded-lg mb-4">
            <h2 class="text-xl font-semibold mb-2">Mengenal Lebih Dekat Penyakit Diabetes</h2>
            <p class="text-gray-700 mb-4">
                Diabetes adalah gangguan metabolisme yang mengakibatkan kadar gula darah tinggi. 
                Pelajari lebih lanjut tentang penyebab, gejala, dan cara pencegahan diabetes melalui artikel ini.
            </p>
        </div>

        <!-- Post 2 -->
        <div class="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 duration-300">
            <img src="{{ asset('img/mental.png') }}" alt="Artikel 2" class="w-full h-40 object-cover rounded-lg mb-4">
            <h2 class="text-xl font-semibold mb-2">Kesehatan Mental: Pentingnya Menjaga Keseimbangan Emosi</h2>
            <p class="text-gray-700 mb-4">
                Menjaga kesehatan mental sangat penting untuk kualitas hidup yang baik. 
                Artikel ini membahas cara-cara menjaga keseimbangan emosi dan mengatasi stres sehari-hari.
            </p>
        </div>

        <!-- Post 3 -->
        <div class="bg-white p-6 rounded-lg shadow-lg transition-transform transform hover:scale-105 duration-300">
            <img src="{{ asset('img/olahraga.jpg') }}" alt="Artikel 3" class="w-full h-40 object-cover rounded-lg mb-4">
            <h2 class="text-xl font-semibold mb-2">Manfaat Olahraga Rutin untuk Kesehatan Jantung</h2>
            <p class="text-gray-700 mb-4">
                Olahraga rutin memiliki banyak manfaat bagi kesehatan jantung. 
                Temukan berbagai jenis olahraga yang bisa Anda lakukan untuk menjaga jantung tetap sehat dan kuat.
            </p>
        </div>
    </div>
</div>
@endsection
