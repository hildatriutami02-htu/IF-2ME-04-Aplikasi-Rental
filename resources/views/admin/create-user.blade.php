@extends('admin.dashboard-admin')

@section('title', 'Tambah User')
@section('page_title', 'Tambah User')
@section('page_desc', 'Tambahkan data pengguna baru')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-slate-800">Form Tambah User</h3>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Kode User</label>
                    <input type="text" name="kode_user" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3" placeholder="USR001">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                    <input type="text" name="no_telp" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3" placeholder="Masukkan nomor telepon">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3" placeholder="Masukkan nama lengkap">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">No WA</label>
                    <input type="text" name="no_wa" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3" placeholder="Masukkan nomor WhatsApp">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">No KTP</label>
                    <input type="text" name="no_ktp" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3" placeholder="Masukkan nomor KTP">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto KTP</label>
                    <input type="file" name="foto_ktp" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3">
                </div>

                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                    <textarea name="alamat" rows="4" class="bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3" placeholder="Masukkan alamat lengkap"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.users') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection