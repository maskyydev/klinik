<?php

namespace App\Http\Controllers;

use App\Models\Konfirmasi;
use App\Models\Obat;
use App\Models\Hasil;
use App\Models\Riwayat;
use App\Models\RiwayatPembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;


class DetailController extends Controller
{
    public function index(Request $request)
    {
        $konfirmasiModel = new Konfirmasi();
        $search = $request->input('search');
        $perPage = 10;

        $query = $konfirmasiModel->where('pilihan', 'KONSULTASI');

        if ($search) {
            $query = $query->where('nama', 'like', "%{$search}%");
        }

        $konfirmasiData = $query->paginate($perPage);

        // Ambil daftar nama dari konfirmasi
        $namaList = $konfirmasiData->pluck('nama')->toArray();

        // Ambil data dari tabel Hasil yang nama-nya cocok
        $hasilData = Hasil::whereIn('nama', $namaList)->get()->keyBy('nama'); // jadi map nama => hasil

        return view('sidebar.detail', [
            'title' => 'Detail Pasien',
            'pasienData' => $konfirmasiData,
            'hasilData' => $hasilData,
            'search' => $search,
        ]);
    }


    public function edit($id)
    {
        $konfirmasi = Konfirmasi::findOrFail($id);
        $hasil = Hasil::where('nama', $konfirmasi->nama)->first();

        $obatList = Obat::all();

        $penyakitList = Obat::select('untuk_penyakit')
                            ->distinct()
                            ->whereNotNull('untuk_penyakit')
                            ->pluck('untuk_penyakit');

        $penyakitValue = $hasil ? $hasil->penyakit : null;

        // Ambil biaya konsultasi dari hasil, kalau tidak ada default 0
        $biayaKonsultasiValue = $hasil ? $hasil->biaya_konsultasi : 0;

        return view('edit.edit_detail', [
            'title' => 'Diagnosa Pasien',
            'pasien' => $konfirmasi,
            'hasil' => $hasil,
            'obatList' => $obatList,
            'penyakitList' => $penyakitList,
            'penyakitValue' => $penyakitValue,
            'biayaKonsultasiValue' => $biayaKonsultasiValue,
        ]);
    }


    public function pembayaran(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|integer',
            'status' => 'required|in:lunas,belum lunas',
        ]);

        // Ambil data konfirmasi berdasarkan pasien_id
        $konfirmasi = Konfirmasi::findOrFail($request->pasien_id);
        $namaPasien = $konfirmasi->nama;

        // Ambil data hasil berdasarkan nama
        $hasil = Hasil::where('nama', $namaPasien)->firstOrFail();

        // Konversi data json ke array (jika diperlukan)
        $obatArray = json_decode($hasil->obat, true);     // contoh: ["Paracetamol", "Amoxicillin"]
        $qtyArray = json_decode($hasil->qty, true);       // contoh: [3, 2]
        $hargaArray = json_decode($hasil->harga, true);   // contoh: [5000, 7000]

        // Loop setiap data obat
        foreach ($obatArray as $index => $namaObat) {
            $qty = isset($qtyArray[$index]) ? (int)$qtyArray[$index] : 0;
            $harga = isset($hargaArray[$index]) ? (int)$hargaArray[$index] : 0;

            // Kurangi stok pada tabel obat
            $obat = Obat::where('nama_obat', $namaObat)->first();
            if ($obat) {
                $obat->stok = max(0, $obat->stok - $qty); // jaga agar tidak negatif
                $obat->save();
            }

            // Simpan ke tabel riwayat
            Riwayat::create([
                'obat' => $namaObat,
                'qty' => -abs($qty), // disimpan sebagai nilai negatif
                'harga' => $harga,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        RiwayatPembayaran::create([
            'nama' => $hasil->nama,
            'penyakit' => $hasil->penyakit,
            'obat' => $hasil->obat,
            'qty' => $hasil->qty,
            'harga' => $hasil->harga,
            'total_harga' => $hasil->total_harga,
            'biaya_konsultasi' => $hasil->biaya_konsultasi,
            'status' => $request->status,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Update status konfirmasi ke SELESAI
        Konfirmasi::where('nama', $namaPasien)
            ->where('pilihan', 'KONSULTASI')
            ->update(['pilihan' => 'SELESAI']);

        // Hapus data hasil
        Hasil::where('nama', $namaPasien)->delete();

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
    

    public function print($id)
    {
        // Ganti Konfirmasi::find dengan RiwayatPembayaran::find
        $riwayat = RiwayatPembayaran::find($id);

        if (!$riwayat) {
            abort(404, "Data dengan ID $id tidak ditemukan.");
        }

        // Siapkan DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Render view ke HTML
        $html = view('print_view', ['pasien' => $riwayat])->render();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Tampilkan PDF di browser
        return $dompdf->stream('nota.pdf', ['Attachment' => false]);
    }
}
