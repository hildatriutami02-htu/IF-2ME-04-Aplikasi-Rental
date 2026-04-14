<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <aside class="w-56 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-base font-bold">
                    L
                </div>
                <div>
                    <h1 class="text-lg font-bold">LensCamp</h1>
                    <p class="text-xs text-slate-300">Ruang Admin</p>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-b border-slate-700">
            <p class="text-sm text-slate-300">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm">{{ session('user') }}</h2>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-2 text-sm">
            <a href="{{ route('dashboard.admin') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Dashboard
            </a>

            <a href="{{ route('admin.users') }}"
               class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">
                Tabel User
            </a>

            <a href="{{ route('admin.products') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Katalog Barang
            </a>

            <a href="{{ route('admin.rentals') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Data Sewa
            </a>

            <a href="{{ route('admin.reports') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Laporan
            </a>

            <a href="{{ route('admin.settings') }}"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Pengaturan Website
            </a>
        </nav>

        <div class="p-3 border-t border-slate-700">
            <a href="{{ route('logout') }}"
               class="block w-full text-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm">
                Keluar
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Tabel User</h2>
                <p class="text-sm text-slate-500">Kelola data pengguna LensCamp</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-800">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">
                    A
                </div>
            </div>
        </header>

        <main class="p-5">
            <div class="max-w-7xl mx-auto">

                @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-100" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-100" role="alert">
                        <p class="font-semibold mb-2">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow">
                    <div class="px-5 py-4 border-b border-gray-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-slate-800">Data User</h3>
                            <p class="text-sm text-slate-500">Daftar semua pengguna/customer LensCamp</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text"
                                    class="block h-10 ps-10 text-sm text-gray-900 border border-gray-300 rounded-xl w-full sm:w-64 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Cari user...">
                            </div>

                            <button data-modal-target="tambahUserModal" data-modal-toggle="tambahUserModal"
                                class="inline-flex items-center justify-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-xl text-sm px-4 h-10">
                                + Tambah Data User
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1100px] text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
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
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-5 py-4">{{ $index + 1 }}</td>
                                        <td class="px-5 py-4 font-medium text-slate-800">{{ $item['kode_user'] ?? '-' }}</td>
                                        <td class="px-5 py-4">{{ $item['nama_lengkap'] ?? $item['nama'] ?? '-' }}</td>
                                        <td class="px-5 py-4">{{ $item['no_ktp'] ?? '-' }}</td>
                                        <td class="px-5 py-4">{{ $item['no_telp'] ?? '-' }}</td>
                                        <td class="px-5 py-4">{{ $item['no_wa'] ?? '-' }}</td>
                                        <td class="px-5 py-4">{{ $item['jenis_kelamin'] ?? '-' }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex justify-center items-center gap-2 whitespace-nowrap">
                                                <a href="{{ route('admin.users.show', $item['id']) }}"
                                                   class="px-2.5 py-1.5 text-[11px] font-medium text-white bg-cyan-500 rounded-md hover:bg-cyan-600">
                                                    Detail
                                                </a>

                                                <button data-modal-target="editUserModal{{ $item['id'] }}"
                                                        data-modal-toggle="editUserModal{{ $item['id'] }}"
                                                        class="px-2.5 py-1.5 text-[11px] font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                                                    Update
                                                </button>

                                                <form action="{{ route('admin.users.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-2.5 py-1.5 text-[11px] font-medium text-white bg-red-500 rounded-md hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- MODAL EDIT USER -->
                                    <div id="editUserModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50">
                                        <div class="relative p-4 w-full max-w-4xl max-h-full">
                                            <div class="relative bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-5 border-b rounded-t">
                                                    <h3 class="text-2xl font-semibold text-gray-900">
                                                        Update Data User
                                                    </h3>
                                                    <button type="button"
                                                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                                        data-modal-hide="editUserModal{{ $item['id'] }}">
                                                        ✕
                                                    </button>
                                                </div>

                                                <form action="{{ route('admin.users.update', $item['id']) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid md:grid-cols-2 gap-5">
                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Kode User</label>
                                                            <input type="text" name="kode_user" value="{{ $item['kode_user'] ?? '' }}"
                                                                class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3" readonly>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                                                            <input type="text" name="no_telp" value="{{ $item['no_telp'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                                                            <input type="text" name="nama_lengkap" value="{{ $item['nama_lengkap'] ?? $item['nama'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">No WA</label>
                                                            <input type="text" name="no_wa" value="{{ $item['no_wa'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">No KTP</label>
                                                            <input type="text" name="no_ktp" value="{{ $item['no_ktp'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto KTP</label>
                                                            <input type="file" name="foto_ktp"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Tempat Lahir</label>
                                                            <input type="text" name="tempat_lahir" value="{{ $item['tempat_lahir'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
                                                            <input type="date" name="tanggal_lahir" value="{{ $item['tanggal_lahir'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                                                            <select name="jenis_kelamin"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                                                                <option value="">-- Pilih --</option>
                                                                <option value="Laki-laki" {{ (($item['jenis_kelamin'] ?? '') === 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                                                <option value="Perempuan" {{ (($item['jenis_kelamin'] ?? '') === 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                                                            </select>
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                                                            <textarea name="alamat" rows="4"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">{{ $item['alamat'] ?? '' }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end gap-3 pt-2">
                                                        <button type="button" data-modal-hide="editUserModal{{ $item['id'] }}"
                                                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                                                            Perbarui
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-6 text-center text-slate-500">
                                            Belum ada data user.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-5 py-4 border-t border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4">
                        <span class="text-sm text-gray-500">
                            Menampilkan
                            <span class="font-semibold text-gray-900">
                                {{ count($users) > 0 ? '1-' . count($users) : '0' }}
                            </span>
                            dari
                            <span class="font-semibold text-gray-900">{{ count($users) }}</span>
                            data
                        </span>

                        <nav aria-label="Page navigation">
                            <ul class="inline-flex -space-x-px text-sm">
                                <li>
                                    <a href="#" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg">
                                        Previous
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50">
                                        1
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-center justify-center px-3 h-8 text-gray-500 bg-white border border-gray-300 rounded-e-lg">
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<!-- MODAL TAMBAH USER -->
<div id="tambahUserModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50">
    <div class="relative p-4 w-full max-w-4xl max-h-full">
        <div class="relative bg-white rounded-2xl shadow">
            <div class="flex items-center justify-between p-5 border-b rounded-t">
                <h3 class="text-2xl font-semibold text-gray-900">
                    Tambah Data User
                </h3>
                <button type="button"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                    data-modal-hide="tambahUserModal">
                    ✕
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
                @csrf

                <div class="grid md:grid-cols-2 gap-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kode User</label>
                        <input type="text" name="kode_user"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="USR001" required>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">No Telp</label>
                        <input type="text" name="no_telp"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="Masukkan nomor telepon">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="Nama lengkap" required>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">No WA</label>
                        <input type="text" name="no_wa"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="08xxxxxxxxxx">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">No KTP</label>
                        <input type="text" name="no_ktp"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="Masukkan nomor KTP" required>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Upload Foto KTP</label>
                        <input type="file" name="foto_ktp"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="Masukkan tempat lahir">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Kelamin</label>
                        <select name="jenis_kelamin"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                        <textarea name="alamat" rows="4"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3"
                            placeholder="Masukkan alamat lengkap"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" data-modal-hide="tambahUserModal"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>