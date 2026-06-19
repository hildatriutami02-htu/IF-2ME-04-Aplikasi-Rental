<?php

namespace App\Http\Controllers;

use App\Models\AkunUser;
use App\Models\DataUser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|size:6',
        ]);

        $user = AkunUser::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'Email atau password salah.'
            ])->withInput();
        }

        session([
            'user' => $user->email,
            'nama' => $user->nama_lengkap,
            'role' => $user->role,
        ]);

        if ($user->role === 'admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('pelanggan.dashboard');
    }

    public function daftar()
    {
        return view('daftar');
    }

    public function daftarProses(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:akun_users,email',
            'password' => 'required|string|size:6',
            'no_ktp' => 'required|string|max:30',
            'no_telp' => 'required|string|max:20',
            'no_wa' => 'required|string|max:20',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
        ]);

        if (DataUser::where('no_ktp', $request->no_ktp)->exists()) {
            return back()->withInput()->withErrors([
                'No KTP sudah terdaftar.'
            ]);
        }

        $nextDataUserId = (DataUser::max('id') ?? 0) + 1;

        DataUser::create([
            'kode_user' => 'USR' . str_pad($nextDataUserId, 3, '0', STR_PAD_LEFT),
            'nama_lengkap' => $request->nama_lengkap,
            'no_ktp' => $request->no_ktp,
            'no_telp' => $request->no_telp,
            'no_wa' => $request->no_wa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
        ]);

        AkunUser::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'pelanggan',
        ]);

        session([
            'user' => $request->email,
            'nama' => $request->nama_lengkap,
            'role' => 'pelanggan',
        ]);

        return redirect()->route('pelanggan.dashboard')
            ->with('success', 'Pendaftaran berhasil.');
    }

    public function logout()
    {
        session()->forget(['user', 'nama', 'role']);

        return redirect()->route('login');
    }
}