<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\MLogin;

class LoginController extends Controller
{
    protected $M_login;

    public function __construct(MLogin $M_login)
    {
        $this->M_login = $M_login;
    }

    // Tampilkan halaman login
    public function index()
    {
        if (Session::has('logged_in')) {
            return redirect('/home');
        }

        return view('login.vieww', ['title' => 'Login']);
    }

    // Tampilkan halaman registrasi
    public function register()
    {
        return view('login.register', ['title' => 'Register']);
    }

   // Proses registrasi
    public function prosesRegister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'user' => 'required|string|unique:users,username',
            'pass' => 'required|string|min:3',
        ]);

        $this->M_login->create([
            'nama' => $request->input('nama'),
            'username' => $request->input('user'),
            'password' => Hash::make($request->input('pass')), // Password di-hash di sini
            'type' => 'user',
        ]);

        return redirect('/login');
    }

    // Proses login
    public function prosesLogin(Request $request)
    {
        $username = $request->input('user');
        $password = $request->input('pass');

        $user = $this->M_login->where('username', $username)->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($password, $user->password)) {
            Session::put([
                'id' => $user->id,
                'username' => $user->username,
                'type' => $user->type,
                'nama' => $user->nama,
                'logged_in' => true,
            ]);

            Session::flash('welcome', $user->nama);

            if ($user->type === 'admin') {
                return redirect('/home');
            } else {
                return redirect('/beranda');
            }
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah');
        }
    }

    // Logout
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
