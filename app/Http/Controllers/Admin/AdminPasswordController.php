<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUser;
use Illuminate\Http\Request;

class AdminPasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password-edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password_lama' => 'required|string|size:6',
            'password_baru' => 'required|string|size:6|confirmed',
        ]);

        $admin = AkunUser::where('email', session('user'))
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return back()->withErrors([
                'Akun admin tidak ditemukan.'
            ]);
        }

        if ($admin->password !== $request->password_lama) {
            return back()->withErrors([
                'Password lama tidak sesuai.'
            ]);
        }

        $admin->update([
            'password' => $request->password_baru,
        ]);

        return back()->with('success', 'Password admin berhasil diperbarui.');
    }
}