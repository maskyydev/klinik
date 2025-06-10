@extends('layoutmin1')

@section('title', 'Tambah Pasien')

@section('content')
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-md w-full animate__animated animate__zoomIn">

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tpasien.store') }}" method="POST">
        @csrf

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-600">Nama Pasien:</label>
                <input type="text" id="nama" name="nama" class="border rounded p-2 w-full" required>
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="border rounded p-2 w-full" required>
            </div>

            <div class="mb-4 hidden">
                <label for="tanggal_daftar" class="block text-sm font-medium text-gray-600">Tanggal Daftar:</label>
                <input type="date" id="tanggal_daftar" name="tanggal_daftar" class="border rounded p-2 w-full" 
                    value="{{ now()->format('Y-m-d') }}" readonly required>
            </div>

            <div class="mb-4">
                <label for="jenkel" class="block text-sm font-medium text-gray-600">Jenis Kelamin:</label>
                <select id="jenkel" name="jenkel" class="border rounded p-2 w-full" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nomor_telepon" class="block text-sm font-medium text-gray-600">Nomor Telepon:</label>
                <input type="tel" id="nomor_telepon" name="nomor_telepon" class="border rounded p-2 w-full" required>
            </div>

            <div class="mb-4 hidden">
                <label for="email" class="block text-sm font-medium text-gray-600">Username:</label>
                <input type="text" id="username" name="username" value="{{ session('username') }}" readonly>
            </div>

            <div class="flex justify-end">
                <button type="submit" 
                    class="px-6 text-green-500 border border-green-500 p-2 hover:bg-green-100 hover:text-green-700">
                    Daftar
                </button>
            </div>
    </form>
</div>
@endsection
