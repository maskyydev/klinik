<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jika belum login atau tipe user bukan 'user'
        if (!Session::has('type') || Session::get('type') !== 'user') {

            // Hindari redirect loop: biarkan akses ke /login dan /prosesLogin
            if (!in_array($request->path(), ['login', 'prosesLogin'])) {
                return redirect('/login');
            }
        }

        return $next($request);
    }
}