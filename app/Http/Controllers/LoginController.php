<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login'); // Ganti dengan nama view login Anda
    }

    // Proses login
    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->intended('dashboard');
    } else {
        Log::warning('Failed authentication attempt.', ['credentials' => $credentials]);
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
}

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/'); // Ganti dengan route atau URL yang Anda inginkan setelah logout
    }
}
