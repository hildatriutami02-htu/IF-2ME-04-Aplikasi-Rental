<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sewa - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-slate-100 text-sm leading-tight">

<div class="flex min-h-screen">

    <aside class="w-52 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-base font-bold">L</div>
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
            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Tabel User</a>
            <a href="{{ route('admin.products') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Katalog Barang</a>
            <a href="{{ route('admin.rentals') }}" class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">Data Sewa</a>
            <a href="{{ route('admin.reports') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Laporan</a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Pengaturan Website</a>
        </nav>

        <div class="p-4 border-t border-slate-700">
            <a href="{{ route('logout') }}" class="block w-full text-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm">
                Keluar
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="bg-white shadow-sm px-4 py-3 flex items-center justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">Data Sewa</h2>
                <p class="text-xs text-slate-500 mt-1">Kelola transaksi penyewaan</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-800">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">A</div>
            </div>
        </header>

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
                    $selectedStatus = request('status', 'semua');
                @endphp

                <div class="bg-white rounded-lg shadow border border-slate-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-200">
                        <h3 class="text-sm font-bold text-slate-800">Input Transaksi Sewa</h3>
                    </div>

                    <form action="{{ route('admin.rentals.store') }}" method="POST" class="p-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Pelanggan</label>
                                <select name="user_id" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user['id'] }}">{{ $user['nama_lengkap'] ?? $user['nama'] ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Barang</label>
                                <select name="product_id" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                    <option value="">Pilih Barang</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product['id'] }}">
                                            {{ $product['nama_barang'] ?? '-' }} - Rp {{ number_format((int) ($product['harga'] ?? 0), 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Qty</label>
                                <input type="number" min="1" name="qty" value="1" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Status Pembayaran</label>
                                <select name="status_pembayaran" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                    <option value="Belum Bayar">Belum Bayar</option>
                                    <option value="DP">DP</option>
                                    <option value="Lunas">Lunas</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Status Transaksi</label>
                                <select name="status_transaksi" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                    <option value="Booking">Booking</option>
                                    <option value="Dikembalikan">Dikembalikan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-gray-900">Catatan</label>
                                <input type="text" name="catatan" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" placeholder="Catatan tambahan">
                            </div>
                        </div>

                        <div class="flex gap-2 pt-3">
                            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm">
                                Simpan
                            </button>
                            <button type="reset" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium text-sm">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow border border-slate-200 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-800">List Transaksi</h3>
                            <p class="text-xs text-slate-500">Filter dan kelola data sewa</p>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.rentals') }}"
                               class="px-4 h-9 inline-flex items-center text-sm rounded-xl {{ $selectedStatus === 'semua' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                                Semua
                            </a>
                            <a href="{{ route('admin.rentals', ['status' => 'Booking']) }}"
                               class="px-4 h-9 inline-flex items-center text-sm rounded-xl {{ $selectedStatus === 'Booking' ? 'bg-yellow-100 text-yellow-700' : 'bg-slate-100 text-slate-700' }}">
                                Booking
                            </a>
                            <a href="{{ route('admin.rentals', ['status' => 'Dikembalikan']) }}"
                               class="px-4 h-9 inline-flex items-center text-sm rounded-xl {{ $selectedStatus === 'Dikembalikan' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">
                                Dikembalikan
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[920px] text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3">Kode</th>
                                    <th class="px-4 py-3">Pelanggan</th>
                                    <th class="px-4 py-3">Barang</th>
                                    <th class="px-4 py-3">Qty</th>
                                    <th class="px-4 py-3">Tgl Pinjam</th>
                                    <th class="px-4 py-3">Tgl Kembali</th>
                                    <th class="px-4 py-3">Total</th>
                                    <th class="px-4 py-3">Pembayaran</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rentals as $item)
                                    @php
                                        $status = $item['status_transaksi'] ?? 'Booking';
                                        $badgeClass = $status === 'Dikembalikan'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-yellow-100 text-yellow-700';

                                        $payClass = 'bg-red-100 text-red-700';
                                        if (($item['status_pembayaran'] ?? '') === 'DP') {
                                            $payClass = 'bg-yellow-100 text-yellow-700';
                                        } elseif (($item['status_pembayaran'] ?? '') === 'Lunas') {
                                            $payClass = 'bg-green-100 text-green-700';
                                        }
                                    @endphp

                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-slate-800">{{ $item['kode_transaksi'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $item['nama_pelanggan'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $item['nama_barang'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $item['qty'] ?? 1 }}</td>
                                        <td class="px-4 py-3">{{ $item['tanggal_pinjam'] ?? '-' }}</td>
                                        <td class="px-4 py-3">{{ $item['tanggal_kembali'] ?? '-' }}</td>
                                        <td class="px-4 py-3">Rp {{ number_format((int) ($item['total_harga'] ?? 0), 0, ',', '.') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $payClass }}">
                                                {{ $item['status_pembayaran'] ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $badgeClass }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex justify-center items-center gap-2 whitespace-nowrap">
                                                <button data-modal-target="detailRentalModal{{ $item['id'] }}"
                                                        data-modal-toggle="detailRentalModal{{ $item['id'] }}"
                                                        class="px-3 py-1.5 text-[11px] text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                    Detail
                                                </button>

                                                <button data-modal-target="editRentalModal{{ $item['id'] }}"
                                                        data-modal-toggle="editRentalModal{{ $item['id'] }}"
                                                        class="px-3 py-1.5 text-[11px] text-white bg-cyan-500 rounded-md hover:bg-cyan-600">
                                                    Update
                                                </button>

                                                <form action="{{ route('admin.rentals.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 text-[11px] text-white bg-red-500 rounded-md hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <div id="detailRentalModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <div class="relative bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900">Detail Transaksi</h3>
                                                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                                        data-modal-hide="detailRentalModal{{ $item['id'] }}">✕</button>
                                                </div>

                                                <div class="p-5 grid md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-xs text-slate-500">Kode Transaksi</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['kode_transaksi'] ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Pelanggan</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['nama_pelanggan'] ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Barang</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['nama_barang'] ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Qty</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['qty'] ?? 1 }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Tanggal Pinjam</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['tanggal_pinjam'] ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Tanggal Kembali</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['tanggal_kembali'] ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Status Pembayaran</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['status_pembayaran'] ?? '-' }}</p>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs text-slate-500">Status Transaksi</p>
                                                        <p class="font-semibold text-slate-800">{{ $item['status_transaksi'] ?? '-' }}</p>
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <p class="text-xs text-slate-500">Total Harga</p>
                                                        <p class="font-semibold text-slate-800">Rp {{ number_format((int) ($item['total_harga'] ?? 0), 0, ',', '.') }}</p>
                                                    </div>
                                                </div>

                                                <div class="px-5 pb-5 flex justify-end">
                                                    <button type="button" data-modal-hide="detailRentalModal{{ $item['id'] }}"
                                                        class="px-4 py-2 text-sm font-medium text-white bg-slate-800 rounded-xl hover:bg-slate-900">
                                                        Tutup
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="editRentalModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/50">
                                        <div class="relative p-4 w-full max-w-3xl max-h-full">
                                            <div class="relative bg-white rounded-2xl shadow">
                                                <div class="flex items-center justify-between p-5 border-b rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900">Update Transaksi</h3>
                                                    <button type="button" class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                                                        data-modal-hide="editRentalModal{{ $item['id'] }}">✕</button>
                                                </div>

                                                <form action="{{ route('admin.rentals.update', $item['id']) }}" method="POST" class="p-5 space-y-4">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid md:grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Pelanggan</label>
                                                            <input type="text" value="{{ $item['nama_pelanggan'] ?? '-' }}"
                                                                class="bg-gray-100 border border-gray-300 text-sm rounded-lg block w-full p-2.5" readonly>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Barang</label>
                                                            <input type="text" value="{{ $item['nama_barang'] ?? '-' }}"
                                                                class="bg-gray-100 border border-gray-300 text-sm rounded-lg block w-full p-2.5" readonly>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Tanggal Pinjam</label>
                                                            <input type="date" name="tanggal_pinjam" value="{{ $item['tanggal_pinjam_raw'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Tanggal Kembali</label>
                                                            <input type="date" name="tanggal_kembali" value="{{ $item['tanggal_kembali_raw'] ?? '' }}"
                                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Qty</label>
                                                            <input type="number" min="1" name="qty" value="{{ $item['qty'] ?? 1 }}"
                                                                class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5" required>
                                                        </div>

                                                        <div>
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Status Pembayaran</label>
                                                            <select name="status_pembayaran" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                                <option value="Belum Bayar" {{ (($item['status_pembayaran'] ?? '') === 'Belum Bayar') ? 'selected' : '' }}>Belum Bayar</option>
                                                                <option value="DP" {{ (($item['status_pembayaran'] ?? '') === 'DP') ? 'selected' : '' }}>DP</option>
                                                                <option value="Lunas" {{ (($item['status_pembayaran'] ?? '') === 'Lunas') ? 'selected' : '' }}>Lunas</option>
                                                            </select>
                                                        </div>

                                                        <div class="md:col-span-2">
                                                            <label class="block mb-1 text-xs font-medium text-gray-900">Status Transaksi</label>
                                                            <select name="status_transaksi" class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                                                                <option value="Booking" {{ (($item['status_transaksi'] ?? '') === 'Booking') ? 'selected' : '' }}>Booking</option>
                                                                <option value="Dikembalikan" {{ (($item['status_transaksi'] ?? '') === 'Dikembalikan') ? 'selected' : '' }}>Dikembalikan</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="flex justify-end gap-3">
                                                        <button type="button" data-modal-hide="editRentalModal{{ $item['id'] }}"
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
                                        <td colspan="10" class="px-4 py-6 text-center text-slate-500">
                                            Belum ada transaksi sewa.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-4 py-3 border-t border-gray-200 flex items-center justify-between">
                        <span class="text-xs text-gray-500">
                            Menampilkan {{ count($rentals) > 0 ? '1-' . count($rentals) : '0' }} dari {{ count($rentals) }} data
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