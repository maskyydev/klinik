@extends('layout1')

@section('content')
  <div class="min-h-screen flex items-center justify-center animate__animated animate__zoomIn">
    <div class="max-w-md w-full bg-white p-6 rounded-md shadow-md">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>
      </div>

      <form action="{{ route('prosesRegister') }}" method="POST">
        @csrf
        <div class="mb-4">
          <label for="nama" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
          <input type="text" id="nama" name="nama" class="w-full border border-gray-300 p-2 rounded-md" required autocomplete="off" placeholder="Masukkan Nama Lengkap">
        </div>

        <div class="mb-4">
          <label for="user" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
          <input type="text" id="user" name="user" class="w-full border border-gray-300 p-2 rounded-md" required autocomplete="off" placeholder="Masukkan Username">
        </div>

        <div class="mb-4">
          <label for="pass" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
          <input type="password" id="pass" name="pass" class="w-full border border-gray-300 p-2 rounded-md" required autocomplete="off" placeholder="Buat Password Anda">
        </div>
        
        <!-- Hidden input to set type to user -->
        <input type="hidden" id="type" name="type" value="user">

        <div class="mb-6">
          <button type="submit" id="loading" class="w-full bg-blue-500 text-white p-2 rounded-md">Register</button>
        </div>

        @if(session('error'))
          <p class="text-red-500">{{ session('error') }}</p>
        @endif

        @if($errors->any())
          <p class="text-red-500">
            @foreach ($errors->all() as $error)
              <div>{{ $error }}</div>
            @endforeach
          </p>
        @endif
      </form>

      <footer class="text-center text-gray-500 text-sm mt-4">
        <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-500">Login di sini</a></p>
      </footer>
    </div>
  </div>
@endsection
