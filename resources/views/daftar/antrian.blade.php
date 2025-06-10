@extends('layout')

@section('title', 'Antrian User')

@section('content')
<!-- Konten Pendaftaran Pasien -->
<div class="mx-auto my-8 p-8 bg-white shadow-md rounded-md w-full max-w-4xl animate__animated animate__zoomIn">
    <h1 class="text-2xl font-semibold mb-4">{{ $title }}</h1>

    <!-- Bagian ini akan di-refresh secara otomatis -->
    <div id="antrian-wrapper">
        @include('daftar._partial_antrian', ['konfirmasi' => $konfirmasi])
    </div>

    <!-- Tabel Antrian -->
    <div class="overflow-x-auto mt-6">
        <table class="min-w-full bg-white border border-gray-300 text-sm sm:text-base">
            <thead class="bg-gray-200 text-left">
                <tr class="text-center">
                    <th class="p-3">No Antrian</th>
                    <th class="p-3">Nama Pasien</th>
                    <th class="p-3">Nomor Telepon</th>
                    <th class="p-3 hidden md:table-cell">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @if($pasienData->count() > 0)
                    @foreach($pasienData as $pasien)
                        <tr class="text-center border-b">
                            <td class="p-3">A00{{ $pasien->id }}</td>
                            <td class="p-3">{{ $pasien->nama }}</td>
                            <td class="p-3">{{ $pasien->nomor_telepon }}</td>
                            <td class="p-3 hidden md:table-cell">
                                {{ \Carbon\Carbon::parse($pasien->tanggal_daftar)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="py-2 px-4 text-center">Tidak ada data</td>
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

<script>
    let lastData = @json($konfirmasi->items());

    setInterval(() => {
        fetch("{{ route('antri') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(res => {
            const newData = res.data;

            if (JSON.stringify(newData) !== JSON.stringify(lastData)) {
                lastData = newData;
                document.getElementById('antrian-wrapper').innerHTML = res.html;
            }
        });
    }, 5000);
</script>
@endsection
