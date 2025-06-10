<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Obat;
use App\Models\RiwayatPembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Menentukan jumlah item per halaman
        $perPage = 7;

        // Jika ada pencarian, ambil data yang sesuai
        if ($search) {
            $riwayatMasuk = Pasien::where('nama', 'like', "%$search%")
                                ->paginate($perPage);
        } else {
            // Jika tidak ada pencarian, ambil semua data
            $riwayatMasuk = Pasien::paginate($perPage);
        }

        return view('transaksi.pembayaran', [
            'riwayatMasuk' => $riwayatMasuk,
            'search' => $search,
            'title' => 'Detail Pembayaran',
        ]);
    }

    public function getDetail($id)
    {
        $pasien = Pasien::findOrFail($id);
        $obat = Obat::where('id', $pasien->obat_id)->first(); // Sesuaikan dengan struktur relasi Anda

        $data = [
            'nama' => $pasien->nama,
            'penyakit' => $pasien->penyakit,
            'obat' => $pasien->obat,
            'qty' => $pasien->qty,
            'harga' => $pasien->harga,
            'obat2' => $pasien->obat2,
            'qty2' => $pasien->qty2,
            'total2' => $pasien->total2,
            'obat3' => $pasien->obat3,
            'qty3' => $pasien->qty3,
            'total3' => $pasien->total3,
            'total' => $pasien->total
        ];

        return response()->json($data);
    }

    public function riset($id)
    {
        $modelPasien = Pasien::findOrFail($id);

        // Hapus data pasien berdasarkan ID
        if ($modelPasien->delete()) {
            // Berikan pesan sukses dan redirect kembali ke halaman pembayaran
            session()->flash('success', 'Data pembayaran telah berhasil dihapus.');
        } else {
            // Berikan pesan error jika penghapusan gagal
            session()->flash('error', 'Gagal menghapus data pembayaran.');
        }

        return redirect()->route('pembayaran.index');
    }

    public function hapusData($id)
{
    $pasienData = Pasien::findOrFail($id);
    $riwayatModel = new RiwayatPembayaran();

    // Pindahkan data ke tabel riwayat_pembayaran
    $riwayatModel->create([
        'nama' => $pasienData->nama,
        'penyakit' => $pasienData->penyakit,
        'obat' => $pasienData->obat,
        'qty' => $pasienData->qty,         // biarkan null jika null
        'total' => $pasienData->total,     // biarkan null jika null
        'obat2' => $pasienData->obat2,
        'qty2' => $pasienData->qty2,
        'total2' => $pasienData->total2,
        'obat3' => $pasienData->obat3,
        'qty3' => $pasienData->qty3,
        'total3' => $pasienData->total3,
        'harga' => $pasienData->harga,     // biarkan null jika null
        'tanggal' => now()->toDateString(),
    ]);

    // Hapus data dari tabel pasien
    if ($pasienData->delete()) {
        session()->flash('success', 'Data Berhasil diperbarui!');
    } else {
        session()->flash('error', 'Data gagal diperbarui!');
    }

    return redirect()->route('riwayatpembayaran.index');
}

}
