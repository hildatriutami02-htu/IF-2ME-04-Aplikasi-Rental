<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Barang - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-slate-100 text-sm leading-tight">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-60 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-base font-bold">
                    L
                </div>
                <div>
                    <h1 class="text-xl font-bold leading-none">LensCamp</h1>
                    <p class="text-xs text-slate-300 mt-1">Ruang Admin</p>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-b border-slate-700">
            <p class="text-xs text-slate-300">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm mt-1">{{ session('user') }}</h2>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-2 text-sm">
            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Tabel User
            </a>
            <a href="{{ route('admin.products') }}" class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">
                Katalog Barang
            </a>
            <a href="{{ route('admin.rentals') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Data Sewa
            </a>
            <a href="{{ route('admin.reports') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Laporan
            </a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Pengaturan Website
            </a>
        </nav>

        <div class="p-4 border-t border-slate-700">
            <a href="{{ route('logout') }}"
               class="block w-full text-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm">
                Keluar
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOPBAR -->
        <header class="bg-white shadow-sm px-5 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Katalog Barang</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola produk rental</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-800">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-base">
                    A
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="p-4">
            <div class="max-w-7xl mx-auto space-y-4">

                @if(session('success'))
                    <div class="rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="rounded-lg bg-red-100 text-red-800 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $totalJenis = collect($products)->pluck('jenis_barang')->filter()->unique()->count();
                    $totalEstimasi = collect($products)->pluck('estimasi')->filter()->unique()->count();
                    $totalStatus = collect($products)->pluck('status')->filter()->unique()->count();
                    $totalUnit = collect($products)->sum('unit');
                @endphp

                <!-- CARDS -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
                    <a href="{{ route('admin.product.settings') }}"
                       class="bg-white rounded-lg shadow border border-slate-200 p-3 flex items-center gap-3 hover:bg-slate-50 transition">
                        <div class="w-11 h-11 rounded-lg bg-cyan-500 text-white flex items-center justify-center text-lg font-bold">
                            ⚙
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Setting Jenis Barang</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ $totalJenis }}</h3>
                        </div>
                    </a>

                    <a href="{{ route('admin.product.settings') }}"
                       class="bg-white rounded-lg shadow border border-slate-200 p-3 flex items-center gap-3 hover:bg-slate-50 transition">
                        <div class="w-11 h-11 rounded-lg bg-red-500 text-white flex items-center justify-center text-lg font-bold">
                            📅
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Setting Estimasi</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ $totalEstimasi }}</h3>
                        </div>
                    </a>

                    <a href="{{ route('admin.product.settings') }}"
                       class="bg-white rounded-lg shadow border border-slate-200 p-3 flex items-center gap-3 hover:bg-slate-50 transition">
                        <div class="w-11 h-11 rounded-lg bg-green-500 text-white flex items-center justify-center text-lg font-bold">
                            🛒
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Setting Status</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ $totalStatus }}</h3>
                        </div>
                    </a>

                    <div class="bg-white rounded-lg shadow border border-slate-200 p-3 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-lg bg-yellow-400 text-slate-900 flex items-center justify-center text-lg font-bold">
                            👥
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Total Unit</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ $totalUnit }}</h3>
                        </div>
                    </div>
                </div>

                <!-- FORM INPUT -->
                <div class="bg-white rounded-lg shadow border border-slate-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-200">
                        <h3 class="text-base font-bold text-slate-800">Input Data Barang</h3>
                    </div>

                    <form action="{{ route('admin.products.store') }}" method="POST" class="p-4">
                        @csrf

                        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">
                            <div class="xl:col-span-3 space-y-3">

                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Kode Barang</label>
                                        <input type="text" name="kode_barang"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Kode Barang">
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Jenis Barang</label>
                                        <input type="text" name="jenis_barang"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Jenis Barang">
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Stok</label>
                                        <input type="number" min="0" name="unit"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Stok" required>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Nama Barang</label>
                                        <input type="text" name="nama_barang"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Nama Barang" required>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Status</label>
                                        <select name="status"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                            <option value="Ready">Ready</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Disewa">Disewa</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Estimasi</label>
                                        <select name="estimasi"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                            <option value="1 /Hari">1 /Hari</option>
                                            <option value="2 /Hari">2 /Hari</option>
                                            <option value="6 /Hari">6 /Hari</option>
                                            <option value="12 /Hari">12 /Hari</option>
                                            <option value="20 /Hari">20 /Hari</option>
                                            <option value="30 /Hari">30 /Hari</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Keterangan</label>
                                        <textarea name="deskripsi" rows="2"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Keterangan barang" required></textarea>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Harga Sewa</label>
                                        <input type="number" min="0" name="harga"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Harga Sewa" required>
                                    </div>

                                    <div>
                                        <label class="block mb-1 text-xs font-medium text-gray-900">Upload Foto Barang</label>
                                        <input type="text" name="gambar"
                                            class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                            placeholder="Link gambar">
                                    </div>
                                </div>

                                <div class="flex gap-2 pt-1">
                                    <button type="submit"
                                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm">
                                        Simpan
                                    </button>
                                    <button type="reset"
                                        class="px-4 py-2 rounded-lg bg-cyan-500 hover:bg-cyan-600 text-white font-medium text-sm">
                                        Batalkan
                                    </button>
                                </div>
                            </div>

                            <div class="xl:col-span-1">
                                <div class="border border-slate-200 rounded-lg p-3 bg-slate-50 min-h-[180px] flex items-center justify-center">
                                    <div class="w-24 h-24 border rounded bg-white flex items-center justify-center text-xs text-slate-400 text-center px-2">
                                        Preview Gambar
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- TABEL -->
                <div class="bg-white rounded-lg shadow border border-slate-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                        <h3 class="text-base font-bold text-slate-800">Katalog Barang</h3>
                        <span class="text-xs text-slate-500">Data barang rental</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[1100px] text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 bg-gray-50 border-b uppercase">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Kode Barang</th>
                                    <th class="px-4 py-3">Nama Barang</th>
                                    <th class="px-4 py-3">Jenis Barang</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Harga</th>
                                    <th class="px-4 py-3">Unit</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $index => $item)
                                    @php
                                        $status = $item['status'] ?? 'Ready';
                                        $badgeClass = 'bg-green-100 text-green-700';

                                        if (strtolower($status) === 'pending') {
                                            $badgeClass = 'bg-yellow-100 text-yellow-700';
                                        } elseif (strtolower($status) === 'disewa') {
                                            $badgeClass = 'bg-blue-100 text-blue-700';
                                        }
                                    @endphp

                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3">{{ $item['kode_barang'] ?? '-' }}</td>
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $item['nama_barang'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $item['jenis_barang'] ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $badgeClass }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">Rp. {{ number_format((int) ($item['harga'] ?? 0), 0, ',', '.') }} /Hari</td>
                                        <td class="px-4 py-3">{{ $item['unit'] ?? 0 }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex justify-center items-center gap-2 whitespace-nowrap">
                                                <button data-modal-target="detailBarangModal{{ $item['id'] }}"
                                                        data-modal-toggle="detailBarangModal{{ $item['id'] }}"
                                                        class="px-3 py-1.5 text-[11px] text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                    Detail
                                                </button>

                                                <button data-modal-target="editBarangModal{{ $item['id'] }}"
                                                        data-modal-toggle="editBarangModal{{ $item['id'] }}"
                                                        class="px-3 py-1.5 text-[11px] text-white bg-cyan-500 rounded-md hover:bg-cyan-600">
                                                    Update
                                                </button>

                                                <form action="{{ route('admin.products.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1.5 text-[11px] text-white bg-red-500 rounded-md hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <div id="detailBarangModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <div class="relative bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900">Detail Barang</h3>
                                                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                                        data-modal-hide="detailBarangModal{{ $item['id'] }}">✕</button>
                                                </div>

                                                <div class="p-5 space-y-4">
                                                    <div class="grid md:grid-cols-2 gap-4">
                                                        <div>
                                                            <p class="text-xs text-slate-500">Kode Barang</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['kode_barang'] ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Nama Barang</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['nama_barang'] ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Jenis Barang</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['jenis_barang'] ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Unit</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['unit'] ?? 0 }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Status</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['status'] ?? '-' }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs text-slate-500">Estimasi</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['estimasi'] ?? '-' }}</p>
                                                        </div>
                                                        <div class="md:col-span-2">
                                                            <p class="text-xs text-slate-500">Keterangan</p>
                                                            <p class="font-semibold text-slate-800">{{ $item['deskripsi'] ?? '-' }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end">
                                                        <button type="button" data-modal-hide="detailBarangModal{{ $item['id'] }}"
                                                            class="px-4 py-2 text-sm font-medium text-white bg-slate-800 rounded-xl hover:bg-slate-900">
                                                            Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="editBarangModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50">
                                        <div class="relative p-4 w-full max-w-3xl max-h-full">
                                            <div class="relative bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900">Update Barang</h3>
                                                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                                        data-modal-hide="editBarangModal{{ $item['id'] }}">✕</button>
                                                </div>

                                                <form action="{{ route('admin.products.update', $item['id']) }}" method="POST" class="p-5 space-y-4">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid md:grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Kode Barang</label>
                                                            <input type="text" name="kode_barang" value="{{ $item['kode_barang'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Jenis Barang</label>
                                                            <input type="text" name="jenis_barang" value="{{ $item['jenis_barang'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Nama Barang</label>
                                                            <input type="text" name="nama_barang" value="{{ $item['nama_barang'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Status</label>
                                                            <select name="status" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                                <option value="Ready" {{ (($item['status'] ?? '') === 'Ready') ? 'selected' : '' }}>Ready</option>
                                                                <option value="Pending" {{ (($item['status'] ?? '') === 'Pending') ? 'selected' : '' }}>Pending</option>
                                                                <option value="Disewa" {{ (($item['status'] ?? '') === 'Disewa') ? 'selected' : '' }}>Disewa</option>
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Estimasi</label>
                                                            <input type="text" name="estimasi" value="{{ $item['estimasi'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Harga</label>
                                                            <input type="number" min="0" name="harga" value="{{ $item['harga'] ?? 0 }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Unit</label>
                                                            <input type="number" min="0" name="unit" value="{{ $item['unit'] ?? 0 }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Keterangan</label>
                                                            <textarea name="deskripsi" rows="3" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>{{ $item['deskripsi'] ?? '' }}</textarea>
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Link Gambar</label>
                                                            <input type="text" name="gambar" value="{{ $item['gambar'] ?? '' }}" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end gap-3">
                                                        <button type="button" data-modal-hide="editBarangModal{{ $item['id'] }}"
                                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200">
                                                            Batal
                                                        </button>
                                                        <button type="submit"
                                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                                                            Perbarui
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-6 text-center text-slate-500">
                                            Belum ada data barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            Menampilkan {{ count($products) > 0 ? '1-' . count($products) : '0' }} dari {{ count($products) }} data
                        </span>
                        <span class="text-xs text-gray-500">Halaman 1</span>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>