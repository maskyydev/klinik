@if ($konfirmasi->count() > 0)
    @foreach ($konfirmasi as $data)
        <div class="p-4 border-b text-center">
            <h1 class="font-bold text-green-600 text-lg">
                PASIEN DENGAN NAMA {{ $data->nama ?? '-' }} SEDANG DALAM PROSES 
                <span class="font-bold text-yellow-600 text-lg">{{ $data->pilihan ?? '-' }}</span>
            </h1>
        </div>
    @endforeach
@else
    <div class="p-4 border-b text-center">
        <h1 class="font-bold text-red-600 text-lg">Tidak ada pasien yang sedang konsultasi !!!</h1>
    </div>
@endif
