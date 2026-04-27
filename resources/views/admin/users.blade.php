@extends('admin.dashboard-admin')

@section('title', 'Data User - LensCamp')
@section('page_title', 'Tabel User')
@section('page_desc', 'Kelola data pengguna LensCamp')

@section('content')
@php
    $alertSuccessClass = 'mb-4 p-4 text-sm text-green-800 rounded-2xl border border-green-200 bg-green-50 shadow-sm';
    $alertErrorClass = 'mb-4 p-4 text-sm text-red-800 rounded-2xl border border-red-200 bg-red-50 shadow-sm';
    $searchInputClass = 'block h-10 ps-10 text-sm text-slate-800 border border-slate-300 rounded-xl w-full sm:w-64 bg-slate-50 focus:ring-4 focus:ring-blue-100 focus:border-blue-500';
    $inputClass = 'w-full rounded-xl border border-slate-300 px-4 py-2 text-sm focus:ring-4 focus:ring-blue-100 focus:border-blue-500';
    $labelClass = 'block mb-2 text-sm font-medium text-slate-700';

    $tableHeaders = [
        'No',
        'Kode User',
        'Nama Lengkap',
        'No KTP',
        'No Telp',
        'No WA',
        'Jenis Kelamin',
    ];
@endphp

<div class="max-w-7xl mx-auto animate-fade-up">

    @if(session('success'))
        <div class="{{ $alertSuccessClass }}">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="{{ $alertErrorClass }}">
            <p class="font-semibold mb-2">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">

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
                    <input
                        type="text"
                        id="searchUser"
                        class="{{ $searchInputClass }}"
                        placeholder="Cari user..."
                        onkeyup="filterUserTable()"
                    >
                </div>

                <button
                    type="button"
                    onclick="openModal('tambahUserModal')"
                    class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-xl text-sm px-4 h-10"
                >
                    + Tambah Data User
                </button>
            </div>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table id="userTable" class="w-full min-w-[1100px] text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        @foreach($tableHeaders as $header)
                            <th class="px-5 py-4">{{ $header }}</th>
                        @endforeach
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $index => $item)
                        <tr class="bg-white border-b border-slate-200 hover:bg-slate-50">
                            <td class="px-5 py-4">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $item->kode_user ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->nama_lengkap ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->no_ktp ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->no_telp ?? '-' }}</td>
                            <td class="px-5 py-4">{{ $item->no_wa ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <span class="px-3 py-1 rounded-full text-xs bg-slate-100">
                                    {{ $item->jenis_kelamin ?? '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a
                                        href="{{ route('admin.users.show', $item->id) }}"
                                        class="px-3 py-2 bg-cyan-500 hover:bg-cyan-600 text-white rounded-lg text-xs"
                                    >
                                        Detail
                                    </a>

                                    <button
                                        type="button"
                                        onclick="openModal('editUserModal{{ $item->id }}')"
                                        class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg text-xs"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openModal('hapusUserModal{{ $item->id }}')"
                                        class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-xs"
                                    >
                                        Hapus
                                    </button>
                                </div>
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

<!-- Modal Tambah -->
<div id="tambahUserModal" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-lg font-semibold text-slate-800">Tambah Data User</h3>
            <button type="button" onclick="closeModal('tambahUserModal')" class="text-slate-500 text-xl">×</button>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="{{ $labelClass }}">Kode User</label>
                    <input type="text" name="kode_user" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="{{ $labelClass }}">No KTP</label>
                    <input type="text" name="no_ktp" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="{{ $labelClass }}">No Telp</label>
                    <input type="text" name="no_telp" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="{{ $labelClass }}">No WA</label>
                    <input type="text" name="no_wa" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="{{ $inputClass }}" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="{{ $inputClass }}">
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Alamat</label>
                    <textarea name="alamat" rows="3" class="{{ $inputClass }}"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Foto KTP</label>
                    <input type="file" name="foto_ktp" class="{{ $inputClass }}">
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal('tambahUserModal')" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@foreach($users as $item)
    <!-- Modal Edit -->
    <div id="editUserModal{{ $item->id }}" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-3xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-5 border-b">
                <h3 class="text-lg font-semibold text-slate-800">Edit Data User</h3>
                <button type="button" onclick="closeModal('editUserModal{{ $item->id }}')" class="text-slate-500 text-xl">×</button>
            </div>

            <form action="{{ route('admin.users.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="p-5 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">Kode User</label>
                        <input type="text" name="kode_user" value="{{ $item->kode_user }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ $item->nama_lengkap }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">No KTP</label>
                        <input type="text" name="no_ktp" value="{{ $item->no_ktp }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">No Telp</label>
                        <input type="text" name="no_telp" value="{{ $item->no_telp }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">No WA</label>
                        <input type="text" name="no_wa" value="{{ $item->no_wa }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="{{ $inputClass }}" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ $item->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $item->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ $item->tempat_lahir }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ $item->tanggal_lahir }}" class="{{ $inputClass }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="{{ $labelClass }}">Alamat</label>
                        <textarea name="alamat" rows="3" class="{{ $inputClass }}">{{ $item->alamat }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="{{ $labelClass }}">Foto KTP</label>
                        <input type="file" name="foto_ktp" class="{{ $inputClass }}">
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('editUserModal{{ $item->id }}')" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-yellow-500 hover:bg-yellow-600 text-white">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus -->
    <div id="hapusUserModal{{ $item->id }}" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-lg w-full max-w-md">
            <div class="p-6 text-center">
                <h3 class="mb-3 text-lg font-semibold text-slate-800">Hapus Data User</h3>
                <p class="text-sm text-slate-500 mb-5">
                    Yakin ingin menghapus user <span class="font-semibold">{{ $item->nama_lengkap }}</span>?
                </p>

                <div class="flex justify-center gap-3">
                    <button type="button" onclick="closeModal('hapusUserModal{{ $item->id }}')" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700">
                        Batal
                    </button>

                    <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function filterUserTable() {
        const input = document.getElementById("searchUser");
        const filter = input.value.toLowerCase();
        const table = document.getElementById("userTable");
        const tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            const rowText = tr[i].textContent.toLowerCase();
            tr[i].style.display = rowText.includes(filter) ? "" : "none";
        }
    }
</script>
@endsection