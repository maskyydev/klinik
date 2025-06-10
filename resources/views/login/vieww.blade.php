@extends('layout1')

@section('content')
  <div class="min-h-screen flex items-center justify-center animate__animated animate__zoomIn">
    <div class="max-w-md w-full bg-white p-6 rounded-md shadow-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>
      </div>

      <form action="{{ route('prosesLogin') }}" method="POST">
        @csrf <!-- Token CSRF untuk keamanan -->

        <div class="mb-4">
          <label for="user" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
          <input type="text" id="user" name="user" class="w-full border border-gray-300 p-2 rounded-md" required autocomplete="off" placeholder="Masukkan Username Anda">
        </div>

        <div class="mb-4">
          <label for="pass" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
          <input type="password" id="pass" name="pass" class="w-full border border-gray-300 p-2 rounded-md" required autocomplete="off" placeholder="Masukkan Password">
        </div><br/>

        <div class="mb-6">
          <button type="submit" id="loading" class="w-full bg-blue-500 text-white p-2 rounded-md">Login</button>
        </div>

        @if(session('error'))
          <p class="text-red-500">{{ session('error') }}</p>
        @endif

        @if($errors->any())
          <p class="text-red-500">{{ implode('', $errors->all('<div>:message</div>')) }}</p>
        @endif
      </form>

      <footer class="text-center text-gray-500 text-sm mt-4">
        <p>Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500">Register di sini</a></p>
      </footer>
    </div>
  </div>

  <!-- Modal Notifikasi Pop-up -->
  @if(session('welcome'))
  <div id="welcomeModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50">
    <div class="bg-white p-6 rounded-md shadow-md max-w-sm w-full">
      <h2 class="text-xl font-semibold mb-4">Selamat Datang</h2>
      <p class="text-gray-700">Selamat datang, {{ session('welcome') }}!</p>
      <button id="closeModal" class="mt-4 bg-blue-500 text-white p-2 rounded-md">Tutup</button>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var modal = document.getElementById('welcomeModal');
      var closeModal = document.getElementById('closeModal');
      var content = document.querySelector('main');
      
      // Sembunyikan konten utama
      content.style.visibility = 'hidden';

      // Tampilkan modal
      modal.classList.remove('hidden');

      // Event listener untuk menutup modal
      closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
        content.style.visibility = 'visible'; // Tampilkan konten kembali
      });
    });
  </script>
  @endif
@endsection
