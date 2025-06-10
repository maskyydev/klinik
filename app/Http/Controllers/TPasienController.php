<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use Illuminate\Support\Facades\Auth;

class TPasienController extends Controller
{
    // Menampilkan form pendaftaran pasien
    public function index()
    {
        return view('sidebar.tambahpasien');
    }

    // Menyimpan data pasien
    public function store(Request $request)
    {
        // Validasi data
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

        return redirect('pasien/antrian')->with('success', 'Pasien berhasil didaftarkan.');
    }
}
