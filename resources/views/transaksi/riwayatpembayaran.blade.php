@extends('layoutmin')
@section('title', 'Riwayat Pembayaran Pasien')

@section('content')
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-5xl w-full animate__animated animate__fadeInUp">
    <h1 class="text-2xl font-bold mb-4">{{ $title }}</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-row flex-wrap justify-between items-center mb-4 gap-2">
        <!-- Form pencarian di kanan -->
        <form action="{{ route('riwayatpembayaran.index') }}" method="GET" class="flex flex-1 w-full sm:w-auto items-center justify-end">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama"
                class="rounded-l-lg p-2 border text-gray-800 border-gray-200 bg-white w-full sm:w-auto" />
            <button type="submit"
                class="px-6 rounded-r-lg bg-blue-500 text-white border border-blue-500 p-2 hover:bg-blue-700 whitespace-nowrap">Cari</button>
        </form>

        <!-- Tombol refresh di kiri -->
        <a href="{{ route('riwayatpembayaran.index') }}"
            class="bg-transparent text-white py-1 px-2 rounded flex-shrink-0">
            <img src="{{ asset('img/refresh.png') }}" class="w-8 h-8">
        </a>
    </div>

    <div class="animate__animated animate__fadeInUp max-w-7xl mx-auto sm:px-6 lg:px-8">
        <table class="min-w-full max-w-full bg-white border border-gray-300 table-auto">
            <thead class="bg-gray-100 text-center text-gray-700 text-sm whitespace-nowrap">
                <tr>
                    <th class="py-3 px-4 border hidden md:table-cell">No</th>
                    <th class="py-3 px-4 border">Nama</th>
                    <th class="py-3 px-4 border hidden md:table-cell">Tanggal</th>
                    <th class="py-3 px-4 border">Detail Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatPembayaran as $riwayat)
                    <tr class="hover:bg-gray-50 transition text-center">
                        <td class="py-2 px-4 border hidden md:table-cell whitespace-nowrap">
                            {{ ($riwayatPembayaran->currentPage() - 1) * $riwayatPembayaran->perPage() + $loop->iteration }}
                        </td>
                        <td class="py-2 px-4 border whitespace-normal max-w-xs break-words text-left">
                            {{ $riwayat->nama }}
                        </td>
                        <td class="py-2 px-4 border hidden md:table-cell whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($riwayat->tanggal)->translatedFormat('d F Y') }}
                        </td>
                        <td class="py-2 px-4 border">
                            <div class="flex flex-nowrap overflow-x-auto justify-center items-center gap-x-2">
                                <button 
                                class="text-green-600 border border-green-600 px-3 py-1 rounded hover:bg-green-100 hover:text-green-700 text-sm transition whitespace-nowrap"
                                onclick='openDetail(@json($riwayat))'>
                                Detail
                                </button>

                                <a href="{{ route('detail.print', ['id' => $riwayat->id]) }}" target="_blank"
                                class="text-red-600 border border-red-600 px-3 py-1 rounded hover:bg-red-100 hover:text-red-700 text-sm transition whitespace-nowrap">
                                Cetak Nota
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-2 px-4 text-center text-gray-500 whitespace-normal">Tidak ada data ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($riwayatPembayaran instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-4">
            {{ $riwayatPembayaran->links('pagination::tailwind') }}
        </div>
    @endif
</div>

<!-- Modal -->
<div id="modalGabungan" class="fixed inset-0 z-50 bg-black bg-opacity-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-8 max-w-3xl w-full relative animate__animated animate__zoomIn shadow-xl">
            <div class="flex justify-between items-center mb-4">
                <h2 id="modalTitle" class="text-3xl font-bold">Detail Pembayaran</h2>
                <button onclick="closeModal()" class="text-gray-600 hover:text-red-600 text-3xl font-bold">&times;</button>
            </div>
            <div id="modalContent" class="overflow-y-auto max-h-[60vh] p-4"></div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('.open-detail');
        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                const data = JSON.parse(this.dataset.riwayat);
                openDetail(data);
            });
        });
    });

    function openDetail(data) {
        const modal = document.getElementById('modalGabungan');
        const modalContent = document.getElementById('modalContent');

        // Pastikan data dalam bentuk array
        const obatArray = Array.isArray(data.obat) ? data.obat : JSON.parse(data.obat || '[]');
        const qtyArray = Array.isArray(data.qty) ? data.qty : JSON.parse(data.qty || '[]');
        const hargaArray = Array.isArray(data.harga) ? data.harga : JSON.parse(data.harga || '[]');

        let rows = '';
        for (let i = 0; i < obatArray.length; i++) {
            rows += `
                <tr>
                    <td class="py-2 px-4">Obat ${i + 1}</td>
                    <td class="py-2 px-4">${obatArray[i] ?? '-'}</td>
                    <td class="py-2 px-4">${qtyArray[i] ?? '-'}</td>
                    <td class="py-2 px-4">${hargaArray[i] ?? '-'}</td>
                </tr>
            `;
        }

        modalContent.innerHTML = `
            <div class="text-sm text-gray-700">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100 text-left text-gray-600">
                            <th class="py-2 px-4">Detail</th>
                            <th class="py-2 px-4">Informasi</th>
                            <th class="py-2 px-4">Jumlah</th>
                            <th class="py-2 px-4">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="py-2 px-4">Nama Pasien</td><td class="py-2 px-4">${data.nama}</td><td></td><td></td></tr>
                        <tr><td class="py-2 px-4">Penyakit</td><td class="py-2 px-4">${data.penyakit}</td><td></td><td></td></tr>
                        ${rows}
                        <tr><td class="py-2 px-4 font-bold">Total Harga</td><td></td><td></td><td class="font-bold">${data.total_harga}</td></tr>
                        <tr><td class="py-2 px-4">Biaya Konsultasi</td><td></td><td></td><td>${data.biaya_konsultasi}</td></tr>
                        <tr><td class="py-2 px-4">Status</td><td></td><td></td><td>${data.status}</td></tr>
                    </tbody>
                </table>
                <div class="flex flex-col items-end mt-4">
                    <img src="{{ asset('img/lunas.png') }}" class="w-24 h-24 mb-2" />
                    <p class="text-sm text-gray-500">${data.tanggal}</p>
                </div>
            </div>
        `;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modalGabungan').classList.add('hidden');
    }
</script>
@endsection
