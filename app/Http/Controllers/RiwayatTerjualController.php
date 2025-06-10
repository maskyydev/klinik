<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Riwayat;

class RiwayatTerjualController extends Controller
{
    public function index(Request $request)
    {

        $title = 'Riwayat Obat Terjual';
        $search = $request->input('search');
        $perPage = 10;

        $modelRiwayat = new Riwayat();

        if ($search) {
            $transactions = $modelRiwayat->searchTransactions($search);
            $transactions = collect($transactions)->slice(($request->input('page', 1) - 1) * $perPage)->take($perPage);
            $pager = null;
        } else {
            $transactions = $modelRiwayat->paginate($perPage);
            $pager = $transactions; // Laravel handles pagination links in Blade
        }

        return view('transaksi.riwayat', compact('title', 'transactions', 'search', 'pager'));
    }

    public function searchTerjual(Request $request)
    {
        if (!Session::has('logged_in')) {
            return redirect('/login');
        }

        $request->validate([
            'search' => 'required|max:100',
        ]);

        $search = $request->input('search');

        $modelRiwayat = new Riwayat();
        $transactions = $modelRiwayat->searchTransactions($search);

        $title = 'Riwayat Obat Terjual';

        return view('transaksi.riwayat', compact('transactions', 'title', 'search'));
    }
}
