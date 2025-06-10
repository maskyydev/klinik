@extends('layoutmin')

@section('title', 'Detail Data Pasien')

@section('content')
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md max-w-3xl w-full sm:max-w-2xl md:max-w-3xl lg:max-w-4xl animate__animated animate__fadeInUp">
    <h1 class="text-2xl font-semibold mb-4">Detail Pasien</h1>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-wrap gap-2 mb-4">
        <form action="{{ url('/detail') }}" method="POST" class="flex items-center w-full sm:w-auto">
            @csrf
            <input type="text" name="search" placeholder="Cari nama pasien" class="flex-grow sm:flex-grow-0 rounded-l-lg p-2 border border-gray-300 text-gray-800 bg-white w-full sm:w-auto" />
            <button type="submit" class="px-6 rounded-r-lg bg-blue-500 text-white border border-blue-500 p-2 hover:bg-blue-700">Cari</button>
        </form>

        <a href="{{ url('/detail') }}" class="ml-auto">
            <img src="{{ asset('img/refresh.png') }}" alt="Refresh" class="w-8 h-8">
        </a>
    </div>

    <!-- GRID TABEL -->
    <div class="overflow-x-auto animate__animated animate__fadeInUp">
        <table class="min-w-full bg-white border border-gray-300 text-sm sm:text-base">
            <thead class="hidden md:table-header-group">
                <tr class="text-center bg-gray-100">
                    <th class="px-4 py-2 border hidden md:table-cell">No</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border hidden md:table-cell">Penyakit</th>
                    <th class="px-4 py-2 border">Membutuhkan Obat</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pasienData as $pasien)
                    @php
                        $hasil = $hasilData[$pasien->nama] ?? null;
                        $obatArray = json_decode($hasil?->obat, true);
                        $adaObat = is_array($obatArray) && count($obatArray) > 0;
                    @endphp
                    <tr class="text-left hover:bg-gray-50">
                        <td class="px-4 py-2 border hidden md:table-cell">A00{{ $pasien->id }}</td>
                        <td class="px-4 py-2 border">{{ $pasien->nama }}</td>

                        <td class="px-4 py-2 border hidden md:table-cell whitespace-pre-line">
                            {{ $hasil?->penyakit ?? '-' }}
                        </td>

                        <td class="px-4 py-2 border whitespace-pre-line">
                            @if ($adaObat)
                                @foreach ($obatArray as $item)
                                    > {{ $item }}<br>
                                @endforeach
                            @else
                                {{ $hasil?->obat ?? '-' }}
                            @endif
                        </td>

                        <td class="px-4 py-2 border">
                            <div class="flex flex-col items-center sm:items-start gap-2">
                                <form action="{{ url('detail/edit/' . $pasien->id) }}" method="GET" class="w-full">
                                    <button type="submit" class="w-full text-green-500 border border-green-500 px-3 py-1 hover:bg-green-100 hover:text-green-700 text-sm">Diagnosa</button>
                                </form>

                                @if ($adaObat)
                                    <button onclick="openModal({{ $pasien->id }})"
                                        class="w-full text-red-500 border border-red-500 px-3 py-1 hover:bg-red-100 hover:text-red-700 text-sm">
                                        Pembayaran
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if (isset($pasienData) && method_exists($pasienData, 'links'))
        <div class="mt-4">
            {{ $pasienData->links('pagination::tailwind') }}
        </div>
    @endif
</div>

@foreach ($pasienData as $pasien)
    @php
        $hasil = $hasilData[$pasien->nama] ?? null;
        $obatArray = json_decode($hasil?->obat, true);
        $adaObat = is_array($obatArray) && count($obatArray) > 0;
    @endphp
    @if ($adaObat)
        <div id="modal-{{ $pasien->id }}" 
             class="fixed inset-0 hidden z-50 bg-black bg-opacity-60 flex items-center justify-center transition-opacity duration-300" 
             style="backdrop-filter: blur(4px);">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md transform scale-90 opacity-0 transition-all duration-300" id="modal-content-{{ $pasien->id }}">
                <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Konfirmasi Pembayaran</h2>
                <p class="mb-6 text-center text-gray-700">
                    Apakah pasien <strong>{{ $pasien->nama }}</strong> sudah melakukan pembayaran?
                </p>
                
                <form action="{{ route('pembayaran.proses') }}" method="POST" class="flex justify-center gap-4">
                    @csrf
                    <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                    <input type="hidden" name="status" value="lunas">
                    <button type="button" 
                            onclick="closeModal({{ $pasien->id }})" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-md shadow-md transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md shadow-md transition duration-200">
                        Sudah Bayar
                    </button>
                </form>
            </div>
        </div>
    @endif
@endforeach

<script>
    function openModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        const content = document.getElementById(`modal-content-${id}`);
        if (modal && content) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        const content = document.getElementById(`modal-content-${id}`);
        if (modal && content) {
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200); // Delay supaya animasi selesai dulu
        }
    }
</script>
@endsection
