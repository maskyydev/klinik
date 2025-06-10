<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Konfirmasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class PasienController extends Controller
{
    // Menampilkan Form Pendaftaran Pasien
    public function index()
    {
        return view('pasien.form', ['title' => 'Form Pendaftaran Pasien']);
    }

    // Menampilkan Form Edit Data Pasien
    public function editForm($id)
    {
        // Ambil data pasien berdasarkan ID
        $pasien = Pasien::find($id);

        if (!$pasien) {
            return redirect()->route('pasien.antrian')->with('error', 'Data tidak ditemukan!');
        }

        return view('edit.edit_form', [
            'title' => 'Form Edit Data',
            'pasien' => $pasien
        ]);
    }

    // Memproses Edit Data Pasien
    public function processEdit(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_daftar' => 'required',
            'jenkel' => 'required',
            'nomor_telepon' => 'required'
        ]);

        // Update data pasien di database
        Pasien::where('id', $id)->update($validatedData);

        return redirect()->route('pasien.antrian')->with('success', 'Data berhasil diubah!');
    }

    // Memproses Pendaftaran Pasien Baru
    public function prosesPasien(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_daftar' => 'required',
            'jenkel' => 'required',
            'nomor_telepon' => 'required',
            'email' => 'required|email'
        ]);

        // Simpan data pasien ke database
        Pasien::create($validatedData);

        return redirect()->route('antri')->with('success', 'Pendaftaran berhasil!');
    }

    public function prosesPasienUser(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'tanggal_daftar' => 'required',
            'jenkel' => 'required',
            'nomor_telepon' => 'required',
            'username' => 'required' // Diisi oleh username login
        ]);

        // Tambahkan user_id secara manual jika ada
        $validatedData['user_id'] = session('user_id'); // atau auth()->id() jika pakai Auth Laravel

        Pasien::create($validatedData);

        return redirect()->route('antri')->with('success', 'Pendaftaran berhasil!');
    }

    // Menampilkan Halaman Antrian Pasien untuk User
    public function antrianUser(Request $request)
    {
        $pasienData = Pasien::paginate(10);
        $konfirmasi = Konfirmasi::where('pilihan', 'KONSULTASI')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('daftar._partial_antrian', compact('konfirmasi'))->render(),
                'data' => $konfirmasi->items()
            ]);
        }

        return view('daftar.antrian', [
            'title' => 'Antrian Pasien',
            'pasienData' => $pasienData,
            'konfirmasi' => $konfirmasi,
        ]);
    }


    // Menampilkan Halaman Antrian Pasien untuk Admin
    public function antrianAdmin(Request $request)
    {
        $search = $request->input('search');
        $pendaftaranDibuka = Cache::get('pendaftaran_dibuka', config('pendaftaran.dibuka')); // default true

        $pasienData = Pasien::where('pilihan', '!=', 'kosong') // exclude 'kosong'
            ->when($search, function ($query) use ($search) {
                return $query->where('nama', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('sidebar.antrian', [
            'title' => 'Data Pasien',
            'pasienData' => $pasienData,
            'search' => $search,
            'pendaftaranDibuka' => $pendaftaranDibuka,
        ]);
    }

    // Toggle buka/tutup pendaftaran
    public function togglePendaftaran()
    {
        $currentStatus = Cache::get('pendaftaran_dibuka', config('pendaftaran.dibuka'));
        Cache::put('pendaftaran_dibuka', !$currentStatus, now()->addDays(7));
        return redirect()->back()->with('success', $currentStatus ? 'Pendaftaran Ditutup' : 'Pendaftaran Dibuka');
    }
    
    public function statusPendaftaran()
    {
        $status = Cache::get('pendaftaran_dibuka', config('pendaftaran.dibuka'));
        return response()->json(['status' => $status]);
    }

    public function konfirmasi($id)
    {
        $pasien = Pasien::findOrFail($id);

        Konfirmasi::create([
            'nama'            => $pasien->nama,
            'alamat'          => $pasien->alamat,
            'tanggal_daftar'  => $pasien->tanggal_daftar,
            'jenkel'          => $pasien->jenkel,
            'nomor_telepon'   => $pasien->nomor_telepon,
            'username'        => $pasien->username,
            'pilihan'         => 'KONSULTASI',
        ]);

        // Ubah nilai pilihan menjadi null, bukan hapus
        $pasien->pilihan = 'kosong';
        $pasien->save();

        return redirect()->back()->with('success', 'Pasien dipindahkan bersiap untuk KONSULTASI.');
    }

    public function batal($id)
    {
        $pasien = Pasien::findOrFail($id);

        Konfirmasi::create([
            'nama'            => $pasien->nama,
            'alamat'          => $pasien->alamat,
            'tanggal_daftar'  => $pasien->tanggal_daftar,
            'jenkel'          => $pasien->jenkel,
            'nomor_telepon'   => $pasien->nomor_telepon,
            'username'        => $pasien->username,
            'pilihan'         => 'DIBATALKAN',
        ]);

        // Ubah nilai pilihan menjadi null, bukan hapus
        $pasien->pilihan = 'kosong';
        $pasien->save();

        return redirect()->back()->with('success', 'Pasien DIBATALKAN.');
    }

    // Menghapus Data Pasien
    public function delete($id)
    {
        Pasien::destroy($id);
        return redirect()->route('pasien.antrian')->with('success', 'Data berhasil dihapus!');
    }
}
