@extends('layoutmin')

@section('title', 'Riwayat Obat Terjual')

@section('content')
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-3xl w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl animate__animated animate__fadeInUp">
    <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex mb-4">
        <!-- Form Pencarian -->
        <form action="{{ route('riwayat.search.terjual') }}" method="POST" class="flex items-center">
            @csrf
            <input type="text" name="search" placeholder="Cari nama obat" class="rounded-l-lg p-2 border-t mr-0 border-b border-l text-gray-800 border-gray-200 bg-white" />
            <button type="submit" class="px-6 rounded-r-lg bg-blue-500 text-white border border-blue-500 border-solid p-2 hover:bg-blue-700">Cari</button>
        </form>

        <!-- Tombol Refresh -->
        <a href="{{ route('riwayat.terjual') }}" class="ml-auto bg-transparent text-white py-1 px-2 rounded animate__animated animate__rubberBand">
            <img src="{{ asset('img/refresh.png') }}" style="width: 30px; height: 30px;">
        </a>
    </div>

    <div class="overflow-x-auto flex">
        <div class="flex-1 mr-4">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="hidden md:table-header-group table-sm">
                    <tr class="text-center bg-gray-100"> 
                        <th class="py-2 px-4 border text-base hidden md:table-cell">No</th>
                        <th class="py-2 px-4 border text-base">Obat</th>
                        <th class="py-2 px-4 border text-base hidden md:table-cell">Harga</th>
                        <th class="py-2 px-4 border text-base">Total</th>
                        <th class="py-2 px-4 border text-base">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr style="text-align: left;">
                            <td class="py-2 px-4 border text-base hidden md:table-cell">
                                {{ ($transactions->currentPage() - 1) * $transactions->perPage() + $loop->iteration }}
                            </td>
                            <td class="py-2 px-4 border text-base">{{ $transaction->obat }}</td>
                            <td class="py-2 px-4 border text-base hidden md:table-cell">{{ $transaction->harga }}</td>
                            <td class="py-2 px-4 border text-base">{{ $transaction->qty }}</td>
                            <td class="py-2 px-4 border text-base">{{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
