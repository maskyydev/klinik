<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Riwayat;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = 10;

        if ($search) {
            $obat = Obat::where('nama_obat', 'like', '%' . $search . '%')
                ->paginate($perPage);
        } else {
            $obat = Obat::paginate($perPage);
        }

        return view('transaksi.obat', [
            'title' => 'Data Obat',
            'obat' => $obat,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('transaksi.form_masuk', ['title' => 'Tambah Obat']);
    }

    public function store(Request $request)
    {
        $nama = $request->input('nama');
        $hargaBeli = $request->input('harga_beli');
        $hargaJual = $request->input('harga_jual');
        $stok = $request->input('stok');

        $existingObat = Obat::where('nama_obat', $nama)
            ->where('harga_beli', $hargaBeli)
            ->where('harga_jual', $hargaJual)
            ->first();

        if ($existingObat) {
            $existingObat->stok += $stok;
            $existingObat->save();

            Riwayat::create([
                'nama_obat' => $nama,
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'stok' => $stok,
            ]);

            return redirect('/obat')->with('success', 'Obat Telah Diperbarui!!');
        } else {
            Obat::create([
                'nama_obat' => $nama,
                'harga_beli' => $hargaBeli,
                'harga_jual' => $hargaJual,
                'stok' => $stok,
            ]);

            return redirect('/obat')->with('success', 'Obat Baru Ditambahkan!!');
        }
    }

    public function edit($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $obat = Obat::findOrFail($id);

        return view('transaksi.form_edit', [
            'title' => 'Edit Data',
            'obat' => $obat,
        ]);
    }

    public function update(Request $request)
    {
        $nama = $request->input('nama');
        $hargaJual = $request->input('harga_jual');
        $stok = $request->input('stok');

        if (!is_numeric($hargaJual) || !is_numeric($stok) || $hargaJual < 0 || $stok < 0) {
            return redirect('/form')->with('error', 'Input tidak valid');
        }

        $hargaTotal = $hargaJual * $stok;

        $existingObat = Obat::where('nama_obat', $nama)->first();

        if ($existingObat) {
            $existingObat->stok = max($existingObat->stok - $stok, 0);
            $existingObat->save();

            Riwayat::create([
                'nama_obat' => $nama,
                'harga_jual' => $hargaTotal,
                'stok' => -$stok,
            ]);

            return redirect('/obat')->with('success', 'Obat Berhasil Terjual!!');
        }

        return redirect('/form')->with('error', 'Obat tidak ditemukan');
    }

    public function delete($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect('/obat')->with('success', 'Obat Berhasil Dihapus dari Penyimpanan!!');
    }

    public function terjual($id)
    {
        $obat = Obat::findOrFail($id);

        return view('transaksi.form_edit', [
            'title' => 'Edit Data',
            'obat' => $obat,
        ]);
    }
}
