@extends('layoutmin1')

@section('title', 'Edit Data Pasien')

@section('content')
    <!-- Konten Edit Pasien -->
    <div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-3xl w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl animate__animated animate__slideInUp">
        <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>

        <!-- Form Edit Pasien -->
        <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
            @csrf
            @method('POST')

            <!-- Nama Pasien -->
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-600">Nama Pasien:</label>
                <input type="text" id="nama" name="nama" class="border rounded p-2 w-full" value="{{ old('nama', $pasien->nama) }}" required>
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-600">Alamat:</label>
                <input type="text" id="alamat" name="alamat" class="border rounded p-2 w-full" value="{{ old('alamat', $pasien->alamat) }}" required>
            </div>

            <!-- Tanggal Daftar (hidden) -->
            <div class="mb-4">
                <input type="hidden" id="tanggal_daftar" name="tanggal_daftar" value="{{ old('tanggal_daftar', $pasien->tanggal_daftar) }}">
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-4">
                <label for="jenkel" class="block text-sm font-medium text-gray-600">Jenis Kelamin:</label>
                <select id="jenkel" name="jenkel" class="border rounded p-2 w-full" required>
                    <option value="Laki-laki" {{ old('jenkel', $pasien->jenkel) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenkel', $pasien->jenkel) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Nomor Telepon -->
            <div class="mb-4">
                <label for="nomor_telepon" class="block text-sm font-medium text-gray-600">Nomor Telepon:</label>
                <input type="tel" id="nomor_telepon" name="nomor_telepon" class="border rounded p-2 w-full" value="{{ old('nomor_telepon', $pasien->nomor_telepon) }}" required>
            </div>

            <!-- Email -->
            <!-- <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-600">Email:</label>
                <input type="email" id="email" name="email" class="border rounded p-2 w-full" value="{{ old('email', $pasien->email) }}" required>
            </div> -->

            <!-- Tombol Aksi -->
            <div class="flex justify-between items-center mt-4">
                <!-- Batal -->
                <a href="{{ url('/antrian') }}" class="px-6 bg-transparent text-red-500 border border-red-500 p-2 hover:bg-gray-100 hover:text-red-700">
                    Batal
                </a>
                <!-- Simpan -->
                <button type="submit" class="px-6 bg-transparent text-green-500 border border-green-500 p-2 hover:bg-gray-100 hover:text-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
