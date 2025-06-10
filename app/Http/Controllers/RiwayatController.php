<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konfirmasi;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $konfirmasiData = Konfirmasi::when($search, function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_daftar', 'desc')
            ->paginate(10);

        return view('sidebar.riwayat', [
            'title' => 'Riwayat Data Pasien',
            'konfirmasiData' => $konfirmasiData,
            'search' => $search,
        ]);
    }
}
