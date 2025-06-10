@extends('layout')

@section('title', 'Pendaftaran Pasien')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-md mt-10">

        {{-- Pesan jika pendaftaran ditutup --}}
        @if (!$pendaftaranDibuka)
            <div id="status-message" class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded shadow-md text-center animate__animated animate__fadeIn">
                <strong class="text-lg block mb-2">Mohon Maaf, Slot Pendaftaran Sudah Habis atau Sedang Ditutup.</strong>
                Silakan coba kembali nanti.
            </div>
        @endif

        {{-- Formulir pendaftaran --}}
        <div id="form-pendaftaran" class="bg-white shadow-md rounded-md p-6 mt-6 animate__animated animate__zoomIn {{ !$pendaftaranDibuka ? 'hidden' : '' }}">
            <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('prosesPasienUser') }}" method="POST">
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
                    <label for="username" class="block text-sm font-medium text-gray-600">Username:</label>
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
    </div>
</div>

{{-- SCRIPT UNTUK AUTO UPDATE STATUS --}}
<script>
    let currentStatus = {{ $pendaftaranDibuka ? 'true' : 'false' }};

    setInterval(() => {
        fetch("{{ route('status.pendaftaran') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== currentStatus) {
                currentStatus = data.status;
                toggleFormDisplay(currentStatus);
            }
        });
    }, 5000);

    function toggleFormDisplay(status) {
        const form = document.getElementById('form-pendaftaran');
        const message = document.getElementById('status-message');

        if (status) {
            form.classList.remove('hidden');
            message.classList.add('hidden');
        } else {
            form.classList.add('hidden');
            message.classList.remove('hidden');
        }
    }
</script>
@endsection
