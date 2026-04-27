<?php

namespace App\Http\Controllers;

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
        $request->validate([
            'kode_user' => 'required|unique:data_users,kode_user',
            'nama_lengkap' => 'required',
            'no_ktp' => 'required|unique:data_users,no_ktp',
            'no_telp' => 'required',
            'no_wa' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_ktp');

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        DataUser::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = DataUser::findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = DataUser::findOrFail($id);

        $request->validate([
            'kode_user' => 'required|unique:data_users,kode_user,' . $id,
            'nama_lengkap' => 'required',
            'no_ktp' => 'required|unique:data_users,no_ktp,' . $id,
            'no_telp' => 'required',
            'no_wa' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable',
            'foto_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('foto_ktp');

        if ($request->hasFile('foto_ktp')) {
            $data['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = DataUser::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil dihapus');
    }
}