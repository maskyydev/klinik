@extends('layoutmin')

@section('title', 'Detail Data Obat')

@section('content')
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-3xl w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl animate__animated animate__fadeInUp">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Data Obat</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol Obat Masuk -->
    <a href="{{ route('obat.create') }}" class="px-6 bg-transparent text-green-500 border border-green-500 border-solid p-2 hover:bg-gray-100 hover:text-green-700">
        Tambah Obat
    </a><br><br>

    <!-- Form Pencarian -->
    <form action="{{ route('obat.index') }}" method="GET" class="flex items-center mb-4 sm:mb-0">
        <input type="text" name="search" placeholder="Cari nama obat"
            class="rounded-l-lg p-2 border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white"
            value="{{ request('search') }}" />
        <button type="submit"
            class="px-6 rounded-r-lg bg-blue-500 text-white border border-blue-500 border-solid p-2 hover:bg-blue-700">
            Cari
        </button>

        <!-- Tombol Refresh -->
        <a href="{{ route('obat.index') }}" class="ml-auto bg-transparent text-white py-1 px-2 rounded animate__animated animate__rubberBand">
            <img src="{{ asset('img/refresh.png') }}" style="width: 30px; height: 30px;">
        </a>
    </form><br>

    <div class="overflow-x-auto animate__animated animate__fadeInUp">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="hidden md:table-header-group">
                <tr class="text-center bg-gray-100"> 
                    <th class="px-4 py-2 border text-base hidden md:table-cell">ID Obat</th>
                    <th class="px-4 py-2 border text-base">Nama Obat</th>
                    <th class="px-4 py-2 border text-base">Harga Jual</th>
                    <th class="px-4 py-2 border text-base hidden md:table-cell">Harga Beli</th>
                    <th class="px-4 py-2 border text-base hidden md:table-cell">Stok</th>
                    <th class="px-4 py-2 border text-base">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($obat as $item)
                    <tr class="text-center block md:table-row border-b md:border-none">
                        <td class="px-4 py-2 border text-base hidden md:table-cell">B00{{ $item->id }}</td>

                        <!-- Nama Obat -->
                        <td class="px-4 py-2 border text-base block md:table-cell">
                            <span class="font-semibold md:hidden">Nama Obat: </span>{{ $item->nama_obat }}
                        </td>

                        <!-- Harga Jual -->
                        <td class="px-4 py-2 border text-base block md:table-cell">
                            <span class="font-semibold md:hidden">Harga Jual: </span>{{ $item->harga_jual }}
                        </td>

                        <!-- Harga Beli -->
                        <td class="px-4 py-2 border text-base hidden md:table-cell">{{ $item->harga_beli }}</td>

                        <!-- Stok -->
                        <td class="px-4 py-2 border text-base hidden md:table-cell">{{ $item->stok }}</td>

                        <!-- Aksi -->
                        <td class="px-4 py-2 border text-base block md:table-cell">
                            <span class="font-semibold md:hidden">Aksi: </span>
                            <div class="flex justify-center md:justify-center space-x-2 mt-2 md:mt-0">
                                <a href="{{ route('obat.terjual', $item->id) }}" class="text-green-500 border border-green-500 px-3 py-1 hover:bg-green-100 hover:text-green-700 text-sm">
                                    Terjual
                                </a>
                                <form action="{{ route('obat.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 border border-red-500 px-3 py-1 hover:bg-red-100 hover:text-red-700 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $obat->links('pagination::tailwind') }}
    </div>
</div>
@endsection
