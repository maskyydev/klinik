@extends('layoutmin')

@section('title', 'Data Pasien')

@section('content')

<!-- Konten -->
<main class="p-4 md:p-8 max-w-7xl mx-auto">

  <div class="bg-white p-6 rounded shadow animate__animated animate__fadeInUp">
    <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>

    @if (session('success'))
      <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        {{ session('success') }}
      </div>
    @endif

    <!-- Baris Atas: Tambah Pasien (kiri) dan Refresh (kanan) -->
    <div class="relative mb-4">
        <!-- Tambah Pasien: kiri -->
        <div class="inline-block">
            <a href="{{ route('sidebar.tambahpasien') }}"
              class="text-green-500 border border-green-500 px-4 py-2 rounded hover:bg-green-100">
              Tambah Pasien
            </a>
        </div>

        <!-- Refresh: kanan -->
        <div class="absolute right-0 top-0">
            <a href="{{ url('pasien/antrian') }}">
                <img src="{{ asset('img/refresh.png') }}" class="w-8 h-8" alt="refresh">
            </a>
        </div>
    </div>

    <!-- Baris Bawah: Form Pencarian (kiri) dan Buka/Tutup Pendaftaran (kanan) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-4">
        <!-- Form Pencarian -->
        <form action="{{ url('pasien/antrian') }}" method="POST" class="flex w-full sm:w-auto">
            @csrf
            <input type="text" name="search" placeholder="Cari nama pasien"
                  value="{{ old('search', $search ?? '') }}"
                  class="flex-grow px-3 py-2 border border-gray-300 rounded-l focus:outline-none" />
            <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-r hover:bg-blue-600">
                Cari
            </button>
        </form>

        <!-- Tombol Buka/Tutup Pendaftaran -->
        <div>
            @if ($pendaftaranDibuka)
                <form action="{{ route('admin.togglePendaftaran') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                        Tutup Pendaftaran
                    </button>
                </form>
            @else
                <form action="{{ route('admin.togglePendaftaran') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        Buka Pendaftaran
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Tabel Pasien -->
    <div class="overflow-x-auto">
      <table class="min-w-full text-sm border border-gray-300">
        <thead class="bg-gray-100 text-gray-700">
          <tr>
            <th class="px-4 py-2 border">No Antrian</th>
            <th class="px-4 py-2 border">Nama Pasien</th>
            <th class="px-4 py-2 border hidden md:table-cell">Telepon</th>
            <th class="px-4 py-2 border hidden md:table-cell">Tanggal Daftar</th>
            <th class="px-4 py-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($pasienData as $pasien)
            <tr class="text-gray-800 text-sm">
              <td class="border px-4 py-2">A00{{ $pasien->id }}</td>
              <td class="border px-4 py-2">{{ $pasien->nama }}</td>
              <td class="border px-4 py-2 hidden md:table-cell">{{ $pasien->nomor_telepon }}</td>
              <td class="border px-4 py-2 hidden md:table-cell">
                {{ \Carbon\Carbon::parse($pasien->tanggal_daftar)->translatedFormat('d F Y') }}
              </td>
              <td class="border px-4 py-2">
                <div class="flex gap-2 justify-center flex-wrap">
                  <a href="{{ route('pasien.edit', $pasien->id) }}" class="text-green-600 border border-green-600 px-3 py-1 rounded hover:bg-green-100">
                    Edit
                  </a>

                  <!-- Tombol Modal -->
                  <button onclick="openModal({{ $pasien->id }})" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Konsultasi
                  </button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      {{ $pasienData->links('pagination::tailwind') }}
    </div>
  </div>

  <!-- Modal -->
  @foreach ($pasienData as $pasien)
    <div id="modal-{{ $pasien->id }}" class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md relative">
            
            <!-- Tombol X -->
            <button onclick="closeModal({{ $pasien->id }})" class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-xl font-bold">
                &times;
            </button>

            <!-- Konten Modal -->
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Hapus</h2>
            <p class="text-gray-600 mb-6">
                Pilih salah satu opsi dibawah ini untuk pasien bernama <strong>{{ $pasien->nama }}</strong> dari antrian?
            </p>

            <div class="flex justify-end gap-2">
                <form action="{{ route('pasien.batal', $pasien->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        Batal Konsultasi
                    </button>
                </form>
                <form action="{{ route('pasien.konfirmasi', $pasien->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Konsultasi
                    </button>
                </form>
            </div>
        </div>
    </div>
  @endforeach

  <script>
      function openModal(id) {
          const modal = document.getElementById('modal-' + id);
          if (modal) {
              modal.classList.remove('hidden');
          }
      }

      function closeModal(id) {
          const modal = document.getElementById('modal-' + id);
          if (modal) {
              modal.classList.add('hidden');
          }
      }
  </script>
</main>
@endsection
