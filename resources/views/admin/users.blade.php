@extends('admin.dashboard-admin')

@section('title', 'Data User - LensCamp')
@section('page_title', 'Tabel User')
@section('page_desc', 'Kelola data pengguna LensCamp')

@section('content')
<div class="max-w-7xl mx-auto animate-fade-up">

    @if(session('success'))
        <div class="mb-4 p-4 text-sm text-green-800 rounded-2xl border border-green-200 bg-green-50 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-4 text-sm text-red-800 rounded-2xl border border-red-200 bg-red-50 shadow-sm">
            <p class="font-semibold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">

        <!-- HEADER -->
        <div class="px-5 py-4 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800">Data User</h3>
                <p class="text-sm text-slate-500">Daftar semua pengguna/customer LensCamp</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        🔍
                    </div>
                    <input type="text"
                        class="block h-10 ps-10 text-sm text-slate-800 border border-slate-300 rounded-xl w-full sm:w-64 bg-slate-50 focus:ring-4 focus:ring-blue-100 focus:border-blue-500"
                        placeholder="Cari user...">
                </div>

                <button data-modal-target="tambahUserModal" data-modal-toggle="tambahUserModal"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-xl text-sm px-4 h-10">
                    + Tambah Data User
                </button>
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full min-w-[1100px] text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4">No</th>
                        <th class="px-5 py-4">Kode User</th>
                        <th class="px-5 py-4">Nama Lengkap</th>
                        <th class="px-5 py-4">No KTP</th>
                        <th class="px-5 py-4">No Telp</th>
                        <th class="px-5 py-4">No WA</th>
                        <th class="px-5 py-4">Jenis Kelamin</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $index => $item)
                        <tr class="bg-white border-b border-slate-200 hover:bg-slate-50">
                            <td class="px-5 py-4">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $item['kode_user'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item['nama_lengkap'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item['no_ktp'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item['no_telp'] ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item['no_wa'] ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <span class="px-3 py-1 rounded-full text-xs bg-slate-100">
                                    {{ $item['jenis_kelamin'] ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <a href="{{ route('admin.users.show', $item['id']) }}"
                                   class="px-2 py-1 bg-cyan-500 text-white rounded">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-6 text-slate-500">
                                Belum ada data user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- MODAL tetap di bawah -->

@endsection