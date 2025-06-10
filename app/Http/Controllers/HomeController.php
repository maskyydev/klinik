<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Konfirmasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cek apakah pengguna sudah login
        if ($this->isLoggedIn()) {
            // Jika sudah login, tampilkan halaman home
            $data['title'] = 'Dashboard';
            return view('sidebar.home', $data);
        }

        return view('rumah');
    }

    /**
     * Menampilkan halaman home untuk admin.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function home()
    {
        // Cek apakah pengguna sudah login
        if (!$this->isLoggedIn()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login');
        }

        // Cek tipe pengguna
        if (session('type') !== 'admin') {
            // Jika pengguna bukan admin, redirect ke halaman beranda
            return redirect()->route('beranda');
        }

        // Jika pengguna adalah admin dan sudah login, tampilkan halaman home admin
        $data['title'] = 'Home';
        return view('sidebar.home', $data);
    }

    /**
     * Menampilkan halaman beranda untuk user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function beranda()
    {
        // Cek apakah pengguna sudah login
        if (!$this->isLoggedIn()) {
            // Jika belum login, redirect ke halaman login
            return redirect()->route('login');
        }

        // Cek tipe pengguna
        if (session('type') === 'admin') {
            // Jika pengguna adalah admin, redirect ke halaman home admin
            return redirect()->route('home');
        }

        // Jika pengguna adalah user dan sudah login, tampilkan halaman beranda
        $data['title'] = 'Dashboard';
        return view('beranda', $data);
    }

    /**
     * Menampilkan halaman pendaftaran pasien untuk user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function pasien()
    {
        // Ambil user yang sedang login
        $user = auth()->user();

        $pendaftaranDibuka = Cache::get('pendaftaran_dibuka', config('pendaftaran.dibuka'));
        return view('daftar.pasien', [
            'pendaftaranDibuka' => $pendaftaranDibuka,
            'title' => 'Form Pendaftaran Pasien',
        ]);
    }


    public function riwayat()
    {
        $username = Session::get('username');

        if (!$username) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Join pasien dengan konfirmasi berdasarkan username dan nama
        $pasienData = Pasien::select('pasien.*', 'konfirmasi.pilihan')
            ->leftJoin('konfirmasi', function($join) {
                $join->on('pasien.username', '=', 'konfirmasi.username')
                    ->on('pasien.nama', '=', 'konfirmasi.nama');
            })
            ->where('pasien.username', $username)
            ->orderBy('pasien.created_at', 'desc')
            ->paginate(10);

        return view('daftar.riwayat', [
            'pasienData' => $pasienData,
            'title' => 'Riwayat Didaftarkan',
        ]);
    }


    /**
     * Cek apakah pengguna sudah login.
     *
     * @return bool
     */
    private function isLoggedIn()
    {
        return session()->has('logged_in') && session('logged_in') === true;
    }
}
