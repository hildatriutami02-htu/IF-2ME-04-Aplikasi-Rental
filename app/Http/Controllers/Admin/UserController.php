<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = DataUser::latest()->get();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_user' => 'required|string|max:50',
            'nama_lengkap' => 'required|string|max:150',
            'no_ktp' => 'required|string|max:50',
            'no_telp' => 'required|string|max:30',
            'no_wa' => 'required|string|max:30',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        DataUser::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show($id)
    {
        $user = DataUser::with('rentals')->findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = DataUser::findOrFail($id);

        $data = $request->validate([
            'kode_user' => 'required|string|max:50',
            'nama_lengkap' => 'required|string|max:150',
            'no_ktp' => 'required|string|max:50',
            'no_telp' => 'required|string|max:30',
            'no_wa' => 'required|string|max:30',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy($id)
    {
        DataUser::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}