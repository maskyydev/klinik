@extends('layout')

@section('title', 'Riwayat Didaftarkan')

@section('content')
<!-- Konten Pendaftaran Pasien -->
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md w-full max-w-4xl animate__animated animate__zoomIn">
    <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>

    <!-- Tabel Riwayat -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 text-sm sm:text-base">
            <thead class="bg-gray-200 text-left">
    <tr class="text-center">
        <th class="p-3">No Antrian</th>
        <th class="p-3">Nama Pasien</th>
        <th class="p-3 hidden md:table-cell">Nomor Telepon</th>
        <th class="p-3 hidden md:table-cell">Tanggal</th>
        <th class="p-3">Pilihan</th> <!-- Tambah kolom pilihan -->
    </tr>
</thead>
<tbody>
    @if($pasienData->count() > 0)
        @foreach($pasienData as $pasien)
            <tr class="text-center border-b">
                <td class="p-3">A00{{ $pasien->id }}</td>
                <td class="p-3">{{ $pasien->nama }}</td>
                <td class="p-3 hidden md:table-cell">{{ $pasien->nomor_telepon }}</td>
                <td class="p-3 hidden md:table-cell">
                    {{ \Carbon\Carbon::parse($pasien->tanggal_daftar)->translatedFormat('d F Y') }}
                </td>
                <td class="p-3 text-center">
                    @if (empty($pasien->pilihan))
                        <span class="font-bold text-black">WAITING ...</span>
                    @elseif ($pasien->pilihan === 'SELESAI')
                        <span class="font-bold text-green-600">SUCCES !!!</span>
                    @elseif ($pasien->pilihan === 'KONSULTASI')
                        <span class="font-bold text-yellow-500">PROCCES ...</span>
                    @elseif ($pasien->pilihan === 'DIBATALKAN')
                        <span class="font-bold text-red-600">CANCEL !!!</span>
                    @else
                        {{ $pasien->pilihan ?? '-' }}
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="5" class="py-2 px-4 text-center">Tidak ada data</td>
        </tr>
    @endif
</tbody>
        </table>
    </div>

    <!-- Pagination Controls -->
    <div class="flex justify-center mt-4">
        {{ $pasienData->links('pagination::tailwind') }}
    </div>
</div>
@endsection
