@extends('layoutmin')

@section('title', 'Riwayat Data Pasien')

@section('content')

<main class="p-4 md:p-8 max-w-7xl mx-auto">

  <div class="bg-white p-6 rounded shadow animate__animated animate__fadeInUp">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

    @if (session('success'))
      <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
      </div>
    @endif

    <!-- Container fleksibel untuk form dan tombol refresh -->
    <div class="flex justify-between items-center mb-4 gap-2 w-full">
        <!-- Form Pencarian -->
        <form action="{{ route('riwayat.pasien') }}" method="GET" class="flex flex-grow max-w-md">
            @csrf
            <input
                type="text"
                name="search"
                placeholder="Cari nama pasien"
                value="{{ request('search') }}"
                class="flex-grow px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded-r-md hover:bg-blue-600 transition">
                Cari
            </button>
        </form>

        <!-- Tombol Refresh di kanan -->
        <div>
            <a href="{{ url('/riwayatpasien') }}" title="Refresh">
                <img src="{{ asset('img/refresh.png') }}" alt="refresh" class="w-8 h-8 hover:opacity-75 transition" />
            </a>
        </div>
    </div>

    <!-- Tabel Riwayat -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border border-gray-300">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Nama Pasien</th>
            <th class="px-4 py-2 border hidden md:table-cell">Alamat</th>
            <th class="px-4 py-2 border hidden md:table-cell">Tanggal Daftar</th>
            <th class="px-4 py-2 border hidden md:table-cell">Jenis Kelamin</th>
            <th class="px-4 py-2 border hidden md:table-cell">Nomor Telepon</th>
            <th class="px-4 py-2 border">Kondisi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($konfirmasiData as $index => $item)
            <tr class="text-gray-800 text-sm">
                <td class="border px-4 py-2">{{ $konfirmasiData->firstItem() + $index }}</td>
                <td class="border px-4 py-2">{{ $item->nama }}</td>
                <td class="border px-4 py-2 hidden md:table-cell">{{ $item->alamat }}</td>
                <td class="border px-4 py-2 hidden md:table-cell">
                    {{ \Carbon\Carbon::parse($item->tanggal_daftar)->translatedFormat('d F Y') }}
                </td>
                <td class="border px-4 py-2 hidden md:table-cell">{{ $item->jenkel }}</td>
                <td class="border px-4 py-2 hidden md:table-cell">{{ $item->nomor_telepon }}</td>
                <td class="border px-4 py-2 capitalize">
                    @if (strtolower($item->pilihan) == 'konsultasi')
                        <span class="text-yellow-600 font-bold">{{ $item->pilihan }}</span>
                    @elseif (strtolower($item->pilihan) == 'dibatalkan')
                        <span class="text-red-600 font-bold">{{ $item->pilihan }}</span>
                    @elseif (strtolower($item->pilihan) == 'selesai')
                        <span class="text-green-600 font-bold">{{ $item->pilihan }}</span>
                    @else
                        {{ $item->pilihan }}
                    @endif
                </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-4 text-gray-500">Data riwayat tidak ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $konfirmasiData->withQueryString()->links('pagination::tailwind') }}
    </div>

  </div>

</main>

@endsection
