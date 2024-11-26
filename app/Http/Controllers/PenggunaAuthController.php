<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PenggunaAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function register(Request $request)
{
    Log::info('Register function called');
    $validated = $request->validate([
        'nomor_identitas' => 'required|unique:penggunas,nomor_identitas',
        'nama' => 'required|string|max:255',
        'username' => 'required|string|unique:penggunas,username|max:255',
        'password' => 'required|string|min:8', // Tanpa konfirmasi password
        'role' => 'required|in:koordinator,siswa', // Hanya untuk role koordinator dan siswa
    ]);

    // Log data yang berhasil divalidasi
    Log::info('Data validated:', $validated);

    // Periksa nomor_identitas di tabel siswah atau koordinator
    $isSiswa = \DB::table('siswahs')->where('nis', $validated['nomor_identitas'])->exists();
    $isKoordinator = \DB::table('koordinators')->where('nip', $validated['nomor_identitas'])->exists();

    if ($validated['role'] === 'siswa' && !$isSiswa) {
        Log::warning('Registration failed: nomor_identitas not found in siswah table', ['nomor_identitas' => $validated['nomor_identitas']]);
        return back()->withErrors(['nomor_identitas' => 'Nomor identitas tidak terdaftar sebagai siswa.']);
    }

    if ($validated['role'] === 'koordinator' && !$isKoordinator) {
        Log::warning('Registration failed: nomor_identitas not found in koordinator table', ['nomor_identitas' => $validated['nomor_identitas']]);
        return back()->withErrors(['nomor_identitas' => 'Nomor identitas tidak terdaftar sebagai koordinator.']);
    }

    // Menyimpan pengguna ke database
    try {
        $user = Pengguna::create([
            'nomor_identitas' => $validated['nomor_identitas'],
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Log keberhasilan penyimpanan
        Log::info('User Created:', $user->toArray());

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login!');
    } catch (\Exception $e) {
        Log::error('Registration failed:', ['error' => $e->getMessage()]);
        return back()->withErrors('Terjadi masalah saat pembuatan akun.');
    }
}

public function login(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    // Gunakan credentials untuk login
    if (auth()->attempt($validated)) {
        return redirect()->route('dashboard');
    } else {
        return back()->withErrors(['username' => 'Username atau password salah']);
    }
}

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
