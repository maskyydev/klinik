@extends('layoutmin1')

@section('title', 'Detail Obat Terjual')

@section('content')
    <!-- Konten Form Edit Obat -->
    <div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-3xl w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl animate__animated animate__slideInUp">
        <h1 class="text-2xl font-semibold mb-4">Detail Obat Terjual</h1>

        <!-- Form Edit Obat -->
        <form action="{{ route('obat.update') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $obat->id }}">

            <div class="my-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Obat:</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $obat->nama_obat) }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full" readonly>
            </div>

            <div class="my-4">
                <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga:</label>
                <input type="text" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $obat->harga_jual) }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full" readonly>
            </div>

            <div class="my-4">
                <label for="stok" class="block text-sm font-medium text-gray-700">Terjual:</label>
                <input type="text" name="stok" id="stok" value="{{ old('stok', $obat->stok) }}" class="mt-1 p-2 border border-gray-300 rounded-md w-full">
            </div>

            <div class="flex justify-between items-center mt-4">
                <!-- Tombol Batal -->
                <a href="{{ route('obat.index') }}" class="px-6 bg-transparent text-red-500 border border-red-500 border-solid p-2 hover:bg-gray-100 hover:text-red-700">
                    Batal
                </a>

                <button type="submit" class="px-6 text-green-700 border border-green-500 border-solid p-2 hover:bg-green-100 hover:text-green-700">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
@endsection
