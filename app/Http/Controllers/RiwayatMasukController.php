<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RiwayatMasukController extends Controller
{
    // Function to handle the 'Obat Masuk' page
    public function obatMasuk(Request $request)
    {
        $search = $request->input('search'); // Get the search query from the input
        $perPage = 10; // Items per page for pagination

        if ($search) {
            // If there's a search query, fetch the results
            $riwayatMasuk = Obat::where('nama_obat', 'like', '%' . $search . '%')->get();
            $pager = null; // No pagination when searching
        } else {
            // If no search, fetch all items with pagination
            $riwayatMasuk = Obat::paginate($perPage);
            $pager = $riwayatMasuk->links(); // Laravel pagination links
        }

        // Pass data to the view
        return view('transaksi.obatmasuk', [
            'riwayatMasuk' => $riwayatMasuk,
            'search' => $search,
            'title' => 'Riwayat Obat Masuk',
            'pager' => $pager
        ]);
    }

    // Function to handle search for 'Obat Masuk'
    public function searchMasuk(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'search' => 'required|max:100',
        ]);

        // Get the search input
        $search = $request->input('search');

        // Perform the search
        $riwayatMasuk = Obat::where('nama_obat', 'like', '%' . $search . '%')->get();

        // Return the result to the same view with search results
        return view('transaksi.obatmasuk', [
            'riwayatMasuk' => $riwayatMasuk,
            'search' => $search,
            'title' => 'Riwayat Obat Masuk',
            'pager' => null // No pagination during search
        ]);
    }
}
