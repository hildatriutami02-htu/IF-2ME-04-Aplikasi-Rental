<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Sub Barang - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="px-5 py-5 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-lg font-bold">
                    L
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-none">LensCamp</h1>
                    <p class="text-sm text-slate-300 mt-1">Ruang Admin</p>
                </div>
            </div>
        </div>

        <div class="px-5 py-5 border-b border-slate-700">
            <p class="text-sm text-slate-300">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm mt-1">{{ session('user') }}</h2>
        </div>

        <nav class="flex-1 px-4 py-5 space-y-2 text-sm">
            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Tabel User</a>
            <a href="{{ route('admin.products') }}" class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">Katalog Barang</a>
            <a href="{{ route('admin.rentals') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Data Sewa</a>
            <a href="{{ route('admin.reports') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Laporan</a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Pengaturan Website</a>
        </nav>

        <div class="p-4 border-t border-slate-700">
            <a href="{{ route('logout') }}"
               class="block w-full text-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm">
                Keluar
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Katalog Sub Barang</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola setting jenis barang, estimasi, dan status</p>
            </div>
            <div class="text-sm text-slate-500">
                <a href="{{ route('dashboard.admin') }}" class="text-blue-600 hover:underline">Home</a>
                <span class="mx-2">/</span>
                <span>Katalog Sub Barang</span>
            </div>
        </header>

        <main class="p-6">
            <div class="max-w-7xl mx-auto">

                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-100 text-green-800 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-lg bg-red-100 text-red-800 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-800">Update Sub Barang</h3>
                    </div>

                    <div class="p-5 grid grid-cols-1 xl:grid-cols-3 gap-6">

                        <!-- JENIS BARANG -->
                        <div class="space-y-4">
                            <form action="{{ route('admin.product.settings.store', 'jenis_barang') }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Jenis Barang</label>
                                    <input type="text" name="nama" placeholder="Tambah Jenis Barang"
                                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                                    Simpan
                                </button>
                            </form>

                            <div class="overflow-hidden rounded-lg border border-slate-200">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Jenis Barang</th>
                                            <th class="px-4 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productSettings['jenis_barang'] as $index => $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-center gap-2">
                                                        <button type="button" data-modal-target="editJenis{{ $item['id'] }}" data-modal-toggle="editJenis{{ $item['id'] }}"
                                                            class="px-3 py-1.5 rounded bg-cyan-500 text-white text-xs hover:bg-cyan-600">
                                                            Update
                                                        </button>
                                                        <form action="{{ route('admin.product.settings.destroy', ['type' => 'jenis_barang', 'id' => $item['id']]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 rounded bg-red-500 text-white text-xs hover:bg-red-600">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div id="editJenis{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                                class="hidden fixed inset-0 z-50 justify-center items-center bg-black/50 p-4">
                                                <div class="w-full max-w-md">
                                                    <div class="bg-white rounded-xl shadow">
                                                        <div class="flex items-center justify-between px-5 py-4 border-b">
                                                            <h3 class="text-lg font-bold text-slate-800">Update Jenis Barang</h3>
                                                            <button type="button" data-modal-hide="editJenis{{ $item['id'] }}" class="text-slate-400 hover:text-slate-700">✕</button>
                                                        </div>
                                                        <form action="{{ route('admin.product.settings.update', ['type' => 'jenis_barang', 'id' => $item['id']]) }}" method="POST" class="p-5 space-y-4">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="text" name="nama" value="{{ $item['nama'] }}"
                                                                   class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                                                            <div class="flex justify-end gap-3">
                                                                <button type="button" data-modal-hide="editJenis{{ $item['id'] }}" class="px-4 py-2 rounded bg-slate-200 text-slate-700 text-sm">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white text-sm">
                                                                    Simpan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-4 text-center text-slate-500">Belum ada data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- ESTIMASI -->
                        <div class="space-y-4">
                            <form action="{{ route('admin.product.settings.store', 'estimasi') }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Estimasi</label>
                                    <input type="text" name="nama" placeholder="Tambah Estimasi"
                                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                                    Simpan
                                </button>
                            </form>

                            <div class="overflow-hidden rounded-lg border border-slate-200">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Estimasi</th>
                                            <th class="px-4 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productSettings['estimasi'] as $index => $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-center gap-2">
                                                        <button type="button" data-modal-target="editEstimasi{{ $item['id'] }}" data-modal-toggle="editEstimasi{{ $item['id'] }}"
                                                            class="px-3 py-1.5 rounded bg-cyan-500 text-white text-xs hover:bg-cyan-600">
                                                            Update
                                                        </button>
                                                        <form action="{{ route('admin.product.settings.destroy', ['type' => 'estimasi', 'id' => $item['id']]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 rounded bg-red-500 text-white text-xs hover:bg-red-600">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div id="editEstimasi{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                                class="hidden fixed inset-0 z-50 justify-center items-center bg-black/50 p-4">
                                                <div class="w-full max-w-md">
                                                    <div class="bg-white rounded-xl shadow">
                                                        <div class="flex items-center justify-between px-5 py-4 border-b">
                                                            <h3 class="text-lg font-bold text-slate-800">Update Estimasi</h3>
                                                            <button type="button" data-modal-hide="editEstimasi{{ $item['id'] }}" class="text-slate-400 hover:text-slate-700">✕</button>
                                                        </div>
                                                        <form action="{{ route('admin.product.settings.update', ['type' => 'estimasi', 'id' => $item['id']]) }}" method="POST" class="p-5 space-y-4">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="text" name="nama" value="{{ $item['nama'] }}"
                                                                   class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                                                            <div class="flex justify-end gap-3">
                                                                <button type="button" data-modal-hide="editEstimasi{{ $item['id'] }}" class="px-4 py-2 rounded bg-slate-200 text-slate-700 text-sm">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white text-sm">
                                                                    Simpan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-4 text-center text-slate-500">Belum ada data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- STATUS -->
                        <div class="space-y-4">
                            <form action="{{ route('admin.product.settings.store', 'status') }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                                    <input type="text" name="nama" placeholder="Tambah Status"
                                           class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white text-sm font-medium hover:bg-blue-700">
                                    Simpan
                                </button>
                            </form>

                            <div class="overflow-hidden rounded-lg border border-slate-200">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3">No</th>
                                            <th class="px-4 py-3">Status</th>
                                            <th class="px-4 py-3 text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productSettings['status'] as $index => $item)
                                            <tr class="border-t">
                                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                                <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex justify-center gap-2">
                                                        <button type="button" data-modal-target="editStatus{{ $item['id'] }}" data-modal-toggle="editStatus{{ $item['id'] }}"
                                                            class="px-3 py-1.5 rounded bg-cyan-500 text-white text-xs hover:bg-cyan-600">
                                                            Update
                                                        </button>
                                                        <form action="{{ route('admin.product.settings.destroy', ['type' => 'status', 'id' => $item['id']]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-3 py-1.5 rounded bg-red-500 text-white text-xs hover:bg-red-600">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <div id="editStatus{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                                class="hidden fixed inset-0 z-50 justify-center items-center bg-black/50 p-4">
                                                <div class="w-full max-w-md">
                                                    <div class="bg-white rounded-xl shadow">
                                                        <div class="flex items-center justify-between px-5 py-4 border-b">
                                                            <h3 class="text-lg font-bold text-slate-800">Update Status</h3>
                                                            <button type="button" data-modal-hide="editStatus{{ $item['id'] }}" class="text-slate-400 hover:text-slate-700">✕</button>
                                                        </div>
                                                        <form action="{{ route('admin.product.settings.update', ['type' => 'status', 'id' => $item['id']]) }}" method="POST" class="p-5 space-y-4">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="text" name="nama" value="{{ $item['nama'] }}"
                                                                   class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm">
                                                            <div class="flex justify-end gap-3">
                                                                <button type="button" data-modal-hide="editStatus{{ $item['id'] }}" class="px-4 py-2 rounded bg-slate-200 text-slate-700 text-sm">
                                                                    Batal
                                                                </button>
                                                                <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white text-sm">
                                                                    Simpan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-4 py-4 text-center text-slate-500">Belum ada data.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>