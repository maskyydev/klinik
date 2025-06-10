@extends('layoutmin1')

@section('title', 'Tambah Data Obat')

@section('content')
    <!-- Konten Form Tambah Obat -->
    <div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-3xl w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl animate__animated animate__slideInUp">
        <h1 class="text-2xl font-semibold mb-4">Tambah Data Obat</h1>

        <!-- Menampilkan pesan error validasi -->
        @if ($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Tambah Obat -->
        <form action="{{ route('obat.store') }}" method="POST">
            @csrf

            <div class="my-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Obat:</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <div class="my-4">
                <label for="harga_beli" class="block text-sm font-medium text-gray-700">Harga Beli:</label>
                <input type="text" name="harga_beli" id="harga_beli" value="{{ old('harga_beli') }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <div class="my-4">
                <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual:</label>
                <input type="text" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <div class="my-4">
                <label for="stok" class="block text-sm font-medium text-gray-700">Stok Bertambah:</label>
                <input type="text" name="stok" id="stok" value="{{ old('stok') }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
@endsection
