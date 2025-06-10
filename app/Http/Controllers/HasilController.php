<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;
use Illuminate\Support\Facades\Log;

class HasilController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'penyakit' => 'nullable|string|max:255',
            'obat' => 'required|array|min:1',
            'obat.*' => 'string|max:255',
            'qty' => 'required|array|min:1',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array|min:1',
            'harga.*' => 'numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'biaya_konsultasi' => 'required|numeric|min:0',
        ]);

        try {
            // Cari data hasil berdasarkan nama
            $hasil = Hasil::where('nama', $request->nama)->first();

            if ($hasil) {
                // Jika data ada, update datanya
                $hasil->update([
                    'penyakit' => $request->penyakit,
                    'obat' => json_encode($request->obat),
                    'qty' => json_encode($request->qty),
                    'harga' => json_encode($request->harga),
                    'total_harga' => $request->total_harga,
                    'biaya_konsultasi' => $request->biaya_konsultasi,
                ]);
            } else {
                // Jika tidak ada, buat data baru
                Hasil::create([
                    'nama' => $request->nama,
                    'penyakit' => $request->penyakit,
                    'obat' => json_encode($request->obat),
                    'qty' => json_encode($request->qty),
                    'harga' => json_encode($request->harga),
                    'total_harga' => $request->total_harga,
                    'biaya_konsultasi' => $request->biaya_konsultasi,
                ]);
            }

            return redirect()->route('detail.index')->with('success', 'Data hasil berhasil disimpan atau diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error menyimpan data hasil: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'penyakit' => 'string|max:255',
            'obat' => 'required|array|min:1',
            'obat.*' => 'string|max:255',
            'qty' => 'required|array|min:1',
            'qty.*' => 'integer|min:1',
            'harga' => 'required|array|min:1',
            'harga.*' => 'numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'biaya_konsultasi' => 'required|numeric|min:0',
        ]);

        try {
            $hasil = Hasil::findOrFail($id);

            $hasil->update([
                'nama' => $request->nama,
                'penyakit' => $request->penyakit,
                'obat' => json_encode($request->obat),
                'qty' => json_encode($request->qty),
                'harga' => json_encode($request->harga),
                'total_harga' => $request->total_harga,
                'biaya_konsultasi' => $request->biaya_konsultasi,
            ]);

            return redirect()->route('detail.index')->with('success', 'Data hasil berhasil diupdate!');
        } catch (\Exception $e) {
            Log::error('Error update data hasil: ' . $e->getMessage());

            return redirect()->back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage()
            ]);
        }
    }
}
