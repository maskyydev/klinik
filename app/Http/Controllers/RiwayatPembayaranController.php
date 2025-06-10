<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPembayaran;
use App\Models\Pasien;
use Illuminate\Support\Facades\Session;

class RiwayatPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 10;

        if ($search) {
            $riwayatPembayaran = RiwayatPembayaran::where('nama', 'like', '%' . $search . '%')
                                    ->paginate($perPage);
        } else {
            $riwayatPembayaran = RiwayatPembayaran::paginate($perPage);
        }

        return view('transaksi.riwayatpembayaran', [
            'riwayatPembayaran' => $riwayatPembayaran,
            'search' => $search,
            'title' => 'Riwayat Pembayaran',
        ]);
    }

    public function detail($id)
    {
        $data = RiwayatPembayaran::find($id);

        if ($data) {
            return response()->json($data);
        }

        return response()->json(['error' => 'Data tidak ditemukan.'], 404);
    }

    public function markAsPaid($id)
    {
        $pasien = Pasien::find($id);

        if ($pasien) {
            // Ambil data array dari pasien (anggap sudah disimpan dalam bentuk array atau bisa dipisah)
            $obatArray  = [$pasien->obat, $pasien->obat2, $pasien->obat3];
            $qtyArray   = [$pasien->qty, $pasien->qty2, $pasien->qty3];
            $hargaArray = [$pasien->total, $pasien->total2, $pasien->total3];

            // Buang nilai null dan kosong
            $obatArray  = array_filter($obatArray);
            $qtyArray   = array_filter($qtyArray);
            $hargaArray = array_filter($hargaArray);

            // Hitung total harga
            $totalHarga = array_sum(array_map('floatval', $hargaArray));

            // Biaya tambahan (bisa kamu atur sesuai kebutuhan, contoh tetap 10000)
            $biayaKonsultasi = 10000;

            // Simpan ke database
            $data = [
                'nama'             => $pasien->nama,
                'penyakit'         => $pasien->penyakit,
                'obat'             => implode(',', $obatArray),
                'qty'              => implode(',', $qtyArray),
                'harga'            => implode(',', $hargaArray),
                'total_harga'      => $totalHarga,
                'biaya_konsultasi' => $biayaKonsultasi,
                'status'           => 'lunas',
                'tanggal'          => now(),
            ];

            RiwayatPembayaran::create($data);
            Session::flash('success', 'Pembayaran berhasil disimpan.');
        } else {
            Session::flash('error', 'Data pasien tidak ditemukan.');
        }

        return redirect('/pembayaran');
    }
}
 