@extends('layoutmin')

@section('title', 'Riwayat Obat Masuk')

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
        <a href="{{ route('riwayat.masuk') }}" class="ml-auto bg-transparent text-white py-1 px-2 rounded animate__animated animate__rubberBand">
            <img src="{{ asset('img/refresh.png') }}" style="width: 30px; height: 30px;">
        </a>
    </div>

    <div class="overflow-x-auto flex">
        <!-- Riwayat Masuk -->
        <div class="flex-1">
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="hidden md:table-header-group">
                    <tr class="text-center bg-gray-100"> 
                        <th class="py-2 px-4 border text-base">No</th>
                        <th class="py-2 px-4 border text-base">Riwayat Obat Yang Masuk</th>
                        <th class="py-2 px-4 border text-base"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatMasuk as $riwayat)
                        <tr class="text-left">
                            <td class="py-2 px-4 border text-base">
                                {{ ($riwayatMasuk->currentPage() - 1) * $riwayatMasuk->perPage() + $loop->iteration }}
                            </td>
                            <td class="py-2 px-4 border text-base">{{ $riwayat->nama_obat }}</td>
                            <td class="py-2 px-4 border text-base">
                                <div class="flex justify-center space-x-2">
                                    <button type="button" onclick="openDetail('{{ json_encode($riwayat) }}', 'masuk')" class="text-green-500 border border-green-500 px-3 py-1 hover:bg-green-100 hover:text-green-700 text-sm">Detail</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($riwayatMasuk instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            {{ $riwayatMasuk->links() }}
        </div>
    @endif
</div>

<!-- Modal -->
<div id="modalGabungan" class="fixed inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="bg-white rounded-lg p-8 max-w-3xl w-full relative animate__animated animate__zoomIn">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modalTitle" class="text-3xl font-semibold">Detail Obat Masuk</h2>
                <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800 focus:outline-none text-4xl">&times;</button>
            </div>
            <div id="modalContent" class="p-4 rounded-md">
                <!-- Detail will be inserted dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
    function openDetail(data, type) {
        var parsedData = JSON.parse(data);
        var modalTitle = document.getElementById('modalTitle');
        var modalContent = document.getElementById('modalContent');

        if (type === 'masuk') {
            modalTitle.textContent = 'Detail Obat Masuk';
            modalContent.innerHTML = `
                <div class="text-sm text-gray-700">
                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="py-2 px-4 text-sm font-medium text-gray-700">Obat</td>
                                <td class="py-2 px-4 text-sm text-gray-500">${parsedData.nama_obat}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm font-medium text-gray-700">Harga Beli</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Rp. ${parsedData.harga_beli}</td>
                            </tr>
                             <tr>
                                <td class="py-2 px-4 text-sm font-medium text-gray-700">Harga Jual</td>
                                <td class="py-2 px-4 text-sm text-gray-500">Rp. ${parsedData.harga_jual}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm font-medium text-gray-700">Jumlah</td>
                                <td class="py-2 px-4 text-sm text-gray-500">${parsedData.stok}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-4 text-sm font-medium text-gray-700">Tanggal</td>
                                <td class="py-2 px-4 text-sm text-gray-500">${parsedData.update_at ? parsedData.update_at : 'N/A'}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `;
        }

        document.getElementById('modalGabungan').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalGabungan').classList.add('hidden');
    }
</script>

@endsection
