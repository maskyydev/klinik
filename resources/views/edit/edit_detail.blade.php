@extends('layoutmin1')

@section('title', 'Diagnosa Data Pasien')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 animate__animated animate__slideInUp">
    <div class="bg-white shadow-lg rounded-lg p-6 md:p-10">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">{{ $title }}</h1>

        {{-- Error Validation --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-6">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hasil.store') }}" method="POST" class="space-y-6" autocomplete="off">
            @csrf
            <input type="hidden" name="id" value="{{ $pasien->id }}">

            {{-- Input Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $pasien->nama) }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring focus:ring-green-200" required>
            </div>

            {{-- Input Penyakit --}}
            <div class="relative">
                <label for="penyakitInput" class="block text-sm font-medium text-gray-700">
                    Penyakit (pisahkan dengan koma)
                </label>
                <input type="text" name="penyakit" id="penyakitInput"
                    value="{{ old('penyakit', $penyakitValue ?? $pasien->penyakit) }}"
                    placeholder="Contoh: Flu, Batuk, Demam"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring focus:ring-green-200"
                    autocomplete="off" spellcheck="false" required />
                <ul id="autocompleteList"
                    class="absolute z-50 w-full bg-white border border-gray-300 rounded-md mt-1 max-h-48 overflow-auto hidden"></ul>
            </div>

            {{-- Dynamic Obat Forms --}}
            <div id="obatContainer" class="space-y-4 mt-6">
                {{-- Form obat akan dibuat oleh JS --}}
            </div>

            {{-- Input Biaya Konsultasi --}}
            <div class="mt-6">
                <label for="biayaKonsultasi" class="block text-sm font-medium text-gray-700">Biaya Konsultasi</label>
                <input type="number" name="biaya_konsultasi" id="biayaKonsultasi" min="0" step="0.01"
                    value="{{ old('biaya_konsultasi', $biayaKonsultasiValue) }}"
                    class="mt-1 w-48 block rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring focus:ring-green-200" required />
            </div>

            {{-- Input Total Keseluruhan --}}
            <div class="text-center mt-6">
                <label for="totalKeseluruhan" class="block text-sm font-medium text-gray-700">Total Keseluruhan (Rp)</label>
                <input type="text" id="totalKeseluruhan" name="total_harga" readonly
                    class="mt-1 mx-auto block w-48 rounded-md border border-gray-300 px-3 py-2 text-center bg-gray-100 shadow-sm"
                    value="{{ old('total_harga', 0) }}" />
            </div>

            {{-- Tombol Simpan dan Batal --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mt-8 space-y-3 sm:space-y-0 sm:space-x-4">
                <a href="{{ url('/detail') }}"
                    class="w-full sm:w-auto text-center px-6 py-2 border border-red-500 text-red-500 rounded-md hover:bg-red-100 transition">
                    Batal
                </a>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 border border-green-500 text-green-500 rounded-md hover:bg-green-100 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const obatList = @json($obatList);
    const penyakitList = @json($penyakitList);

    const penyakitInput = document.getElementById('penyakitInput');
    const autocompleteList = document.getElementById('autocompleteList');
    const obatContainer = document.getElementById('obatContainer');
    const biayaKonsultasiInput = document.getElementById('biayaKonsultasi');
    const totalKeseluruhanInput = document.getElementById('totalKeseluruhan');

    // Mapping penyakit ke obat
    const penyakitToObat = {};
    obatList.forEach(obat => {
        if (!obat.untuk_penyakit) return;
        obat.untuk_penyakit.split(',').map(p => p.trim().toLowerCase()).forEach(p => {
            if (!penyakitToObat[p]) penyakitToObat[p] = [];
            if (!penyakitToObat[p].includes(obat.nama_obat)) {
                penyakitToObat[p].push(obat.nama_obat);
            }
        });
    });

    function getPenyakitTerpilih() {
        return penyakitInput.value
            .split(',')
            .map(s => s.trim().toLowerCase())
            .filter(Boolean);
    }

    function getCurrentTyping() {
        const parts = penyakitInput.value.split(',');
        return parts[parts.length - 1].trim().toLowerCase();
    }

    function showAutocomplete() {
        const currentTyping = getCurrentTyping();
        if (!currentTyping) return autocompleteList.classList.add('hidden');

        const suggestions = penyakitList.filter(p => p.toLowerCase().includes(currentTyping));

        if (suggestions.length === 0) {
            autocompleteList.classList.add('hidden');
            return;
        }

        autocompleteList.innerHTML = suggestions
            .map(p => `<li class="cursor-pointer px-3 py-1 hover:bg-green-200">${p}</li>`)
            .join('');
        autocompleteList.classList.remove('hidden');
    }

    autocompleteList.addEventListener('click', e => {
        if (e.target.tagName.toLowerCase() === 'li') {
            const selected = e.target.textContent.trim();
            let parts = penyakitInput.value.split(',');
            parts[parts.length - 1] = selected;
            penyakitInput.value = parts.map(s => s.trim()).filter(Boolean).join(', ') + ', ';
            autocompleteList.innerHTML = '';
            autocompleteList.classList.add('hidden');
            updateObatForms();
            updateTotalKeseluruhan();
            penyakitInput.focus();
        }
    });

    document.addEventListener('click', e => {
        if (!autocompleteList.contains(e.target) && e.target !== penyakitInput) {
            autocompleteList.innerHTML = '';
            autocompleteList.classList.add('hidden');
        }
    });

    penyakitInput.addEventListener('input', () => {
        showAutocomplete();
        if (penyakitInput.value.endsWith(',')) updateObatForms();
        updateTotalKeseluruhan();
    });

    function updateObatForms() {
        obatContainer.innerHTML = '';
        const penyakitArray = getPenyakitTerpilih();
        const obatSudahDitampilkan = new Set();
        let index = 0;

        penyakitArray.forEach(p => {
            if (!penyakitToObat[p]) return;

            penyakitToObat[p].forEach(namaObat => {
                if (obatSudahDitampilkan.has(namaObat)) return;
                obatSudahDitampilkan.add(namaObat);
                index++;

                const found = obatList.find(o => o.nama_obat === namaObat);
                const hargaSatuan = found ? parseFloat(found.harga_jual) : 0;
                const defaultQty = 1;
                const hargaTotal = hargaSatuan * defaultQty;

                const formDiv = document.createElement('div');
                formDiv.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 items-end';

                // Label & select obat
                const labelObat = document.createElement('label');
                labelObat.className = 'text-sm font-medium text-gray-700';
                labelObat.textContent = `Obat ${index}`;

                const selectObat = document.createElement('select');
                selectObat.name = `obat[]`;
                selectObat.className = 'mt-1 p-2 border border-gray-300 rounded-md w-full';
                selectObat.innerHTML = `<option value="${namaObat}" selected>${namaObat}</option>`;

                // Label & select qty
                const labelQty = document.createElement('label');
                labelQty.className = 'text-sm font-medium text-gray-700';
                labelQty.textContent = 'Jumlah';

                const selectQty = document.createElement('select');
                selectQty.name = `qty[]`;
                selectQty.className = 'mt-1 p-2 border border-gray-300 rounded-md w-full';
                for (let i = 1; i <= 10; i++) {
                    selectQty.innerHTML += `<option value="${i}">${i}</option>`;
                }
                selectQty.value = defaultQty;

                // Label & harga per item (harga[] = array)
                const labelHarga = document.createElement('label');
                labelHarga.className = 'text-sm font-medium text-gray-700';
                labelHarga.textContent = 'Harga (Rp)';

                const inputHarga = document.createElement('input');
                inputHarga.type = 'number';
                inputHarga.name = `harga[]`; // Array harga untuk tiap obat
                inputHarga.className = 'mt-1 p-2 border border-gray-300 rounded-md w-full bg-gray-100';
                inputHarga.readOnly = true;
                inputHarga.value = hargaTotal.toFixed(2);

                // Struktur form obat & qty & harga dalam satu baris grid
                formDiv.appendChild(labelObat);
                formDiv.appendChild(selectObat);
                formDiv.appendChild(document.createElement('br'));
                formDiv.appendChild(labelQty);
                formDiv.appendChild(selectQty);
                formDiv.appendChild(document.createElement('br'));
                formDiv.appendChild(labelHarga);
                formDiv.appendChild(inputHarga);

                obatContainer.appendChild(formDiv);

                // Event on change qty -> update harga per item dan total keseluruhan
                selectQty.addEventListener('change', () => {
                    const qty = parseInt(selectQty.value) || 0;
                    inputHarga.value = (hargaSatuan * qty).toFixed(2);
                    updateTotalKeseluruhan();
                });
            });
        });

        updateTotalKeseluruhan();
    }

    function updateTotalKeseluruhan() {
        let total = 0;

        // Jumlahkan harga[] semua form obat
        document.querySelectorAll('input[name="harga[]"]').forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) total += val;
        });

        // Tambah biaya konsultasi
        const biayaKonsultasi = parseFloat(biayaKonsultasiInput.value);
        if (!isNaN(biayaKonsultasi)) total += biayaKonsultasi;

        totalKeseluruhanInput.value = total.toFixed(2);
    }

    biayaKonsultasiInput.addEventListener('input', updateTotalKeseluruhan);

    // Inisialisasi pertama form obat dan total
    updateObatForms();
});
</script>
@endsection
