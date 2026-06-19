<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profil = session('profil', [
            'nama' => session('user') ?? 'Pelanggan',
            'email' => session('user') ?? 'pelanggan@email.com',
            'no_wa' => '081234567890',
            'alamat' => 'Batam, Indonesia',
            'status' => 'Terverifikasi',
        ]);

        return view('pelanggan.profil', compact('profil'));
    }

    public function update(Request $request)
    {
        $profil = $request->validate([
            'nama' => 'required|string|max:150',
            'email' => 'required|email',
            'no_wa' => 'required|string|max:30',
            'alamat' => 'required|string',
        ]);

        $profil['status'] = 'Terverifikasi';

        session(['profil' => $profil]);

        return redirect()->route('pelanggan.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}