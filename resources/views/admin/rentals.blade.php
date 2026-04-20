@extends('admin.dashboard-admin')

@section('title', 'Data Sewa - LensCamp')
@section('page_title', 'Data Sewa')
@section('page_desc', 'Kelola transaksi penyewaan')

@section('content')
<div class="max-w-7xl mx-auto space-y-4 animate-fade-up">

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm shadow-sm">
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

    <!-- FORM INPUT -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-4 py-3 border-b border-slate-200">
            <h3 class="text-sm font-bold text-slate-800">Input Transaksi Sewa</h3>
        </div>

        <form action="{{ route('admin.rentals.store') }}" method="POST" class="p-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Pelanggan</label>
                    <select name="user_id" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach($users as $user)
                            <option value="{{ $user['id'] }}">
                                {{ $user['nama_lengkap'] ?? $user['nama'] ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Barang</label>
                    <select name="product_id" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                        <option value="">Pilih Barang</option>
                        @foreach($products as $product)
                            <option value="{{ $product['id'] }}">
                                {{ $product['nama_barang'] ?? '-' }} - Rp {{ number_format((int) ($product['harga'] ?? 0), 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Qty</label>
                    <input type="number" min="1" name="qty" value="1" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Status Pembayaran</label>
                    <select name="status_pembayaran" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="DP">DP</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Status Transaksi</label>
                    <select name="status_transaksi" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                        <option value="Booking">Booking</option>
                        <option value="Dikembalikan">Dikembalikan</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Catatan</label>
                    <input type="text" name="catatan" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" placeholder="Catatan tambahan">
                </div>
            </div>

            <div class="flex gap-2 pt-3">
                <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Simpan
                </button>
                <button type="reset" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium text-sm transition-all duration-300 hover:-translate-y-0.5">
                    Reset
                </button>
            </div>
        </form>
    </div>

    <!-- LIST -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-4 py-3 border-b border-slate-200 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">
            <div>
                <h3 class="text-sm font-bold text-slate-800">List Transaksi</h3>
                <p class="text-xs text-slate-500">Filter dan kelola data sewa</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.rentals') }}"
                   class="px-4 h-9 inline-flex items-center text-sm rounded-xl transition-all duration-200 {{ $selectedStatus === 'semua' ? 'bg-blue-600 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua
                </a>
                <a href="{{ route('admin.rentals', ['status' => 'Booking']) }}"
                   class="px-4 h-9 inline-flex items-center text-sm rounded-xl transition-all duration-200 {{ $selectedStatus === 'Booking' ? 'bg-yellow-100 text-yellow-700 shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Booking
                </a>
                <a href="{{ route('admin.rentals', ['status' => 'Dikembalikan']) }}"
                   class="px-4 h-9 inline-flex items-center text-sm rounded-xl transition-all duration-200 {{ $selectedStatus === 'Dikembalikan' ? 'bg-green-100 text-green-700 shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Dikembalikan
                </a>
            </div>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full min-w-[920px] text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
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

                        <tr class="bg-white border-b border-slate-200 hover:bg-slate-50 transition-colors duration-200">
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
                                            class="px-3 py-1.5 text-[11px] text-white bg-blue-500 rounded-md hover:bg-blue-600 transition-all duration-200 hover:-translate-y-0.5">
                                        Detail
                                    </button>

                                    <button data-modal-target="editRentalModal{{ $item['id'] }}"
                                            data-modal-toggle="editRentalModal{{ $item['id'] }}"
                                            class="px-3 py-1.5 text-[11px] text-white bg-cyan-500 rounded-md hover:bg-cyan-600 transition-all duration-200 hover:-translate-y-0.5">
                                        Update
                                    </button>

                                    <form action="{{ route('admin.rentals.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-[11px] text-white bg-red-500 rounded-md hover:bg-red-600 transition-all duration-200 hover:-translate-y-0.5">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
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

        <div class="px-4 py-3 border-t border-slate-200 flex items-center justify-between">
            <span class="text-xs text-slate-500">
                Menampilkan {{ count($rentals) > 0 ? '1-' . count($rentals) : '0' }} dari {{ count($rentals) }} data
            </span>
            <span class="text-xs text-slate-500">Halaman 1</span>
        </div>
    </div>

    <!-- MODALS DI LUAR TABLE -->
    @foreach($rentals as $item)
        @php
            $status = $item['status_transaksi'] ?? 'Booking';
            $payClass = 'bg-red-100 text-red-700';
            if (($item['status_pembayaran'] ?? '') === 'DP') {
                $payClass = 'bg-yellow-100 text-yellow-700';
            } elseif (($item['status_pembayaran'] ?? '') === 'Lunas') {
                $payClass = 'bg-green-100 text-green-700';
            }

            $statusClass = $status === 'Dikembalikan'
                ? 'bg-green-100 text-green-700'
                : 'bg-yellow-100 text-yellow-700';
        @endphp

        <!-- DETAIL MODAL -->
        <div id="detailRentalModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-white/95">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-xl">
                    <div class="flex items-center justify-between p-5 border-b border-slate-200 rounded-t">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">Detail Transaksi</h3>
                            <p class="text-sm text-slate-500 mt-1">Informasi lengkap transaksi sewa</p>
                        </div>
                        <button type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition"
                            data-modal-hide="detailRentalModal{{ $item['id'] }}">✕</button>
                    </div>

                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">Kode Transaksi</p>
                                <p class="mt-1 text-2xl font-bold text-slate-800">{{ $item['kode_transaksi'] ?? '-' }}</p>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">Total Harga</p>
                                <p class="mt-1 text-2xl font-bold text-slate-800">Rp {{ number_format((int) ($item['total_harga'] ?? 0), 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-500">Pelanggan</p>
                                <p class="mt-1 font-semibold text-slate-800 text-lg">{{ $item['nama_pelanggan'] ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-500">Barang</p>
                                <p class="mt-1 font-semibold text-slate-800 text-lg">{{ $item['nama_barang'] ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-500">Tanggal Pinjam</p>
                                <p class="mt-1 font-semibold text-slate-800 text-lg">{{ $item['tanggal_pinjam'] ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-500">Tanggal Kembali</p>
                                <p class="mt-1 font-semibold text-slate-800 text-lg">{{ $item['tanggal_kembali'] ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-500">Qty</p>
                                <p class="mt-1 font-semibold text-slate-800 text-lg">{{ $item['qty'] ?? 1 }}</p>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Status Pembayaran</p>
                                    <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $payClass }}">
                                        {{ $item['status_pembayaran'] ?? '-' }}
                                    </span>
                                </div>

                                <div>
                                    <p class="text-xs text-slate-500 mb-1">Status Transaksi</p>
                                    <span class="px-3 py-1.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ $item['status_transaksi'] ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end">
                            <button type="button" data-modal-hide="detailRentalModal{{ $item['id'] }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-slate-800 rounded-xl hover:bg-slate-900 transition-all duration-300 hover:-translate-y-0.5">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div id="editRentalModal{{ $item['id'] }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-xl">
                    <div class="flex items-center justify-between p-5 border-b border-slate-200 rounded-t">
                        <h3 class="text-xl font-semibold text-slate-900">Update Transaksi</h3>
                        <button type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition"
                            data-modal-hide="editRentalModal{{ $item['id'] }}">✕</button>
                    </div>

                    <form action="{{ route('admin.rentals.update', $item['id']) }}" method="POST" class="p-5 space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Pelanggan</label>
                                <input type="text" value="{{ $item['nama_pelanggan'] ?? '-' }}"
                                    class="bg-slate-100 border border-slate-300 text-sm rounded-xl block w-full p-2.5" readonly>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Barang</label>
                                <input type="text" value="{{ $item['nama_barang'] ?? '-' }}"
                                    class="bg-slate-100 border border-slate-300 text-sm rounded-xl block w-full p-2.5" readonly>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Pinjam</label>
                                <input type="date" name="tanggal_pinjam" value="{{ $item['tanggal_pinjam_raw'] ?? '' }}"
                                    class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Kembali</label>
                                <input type="date" name="tanggal_kembali" value="{{ $item['tanggal_kembali_raw'] ?? '' }}"
                                    class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Qty</label>
                                <input type="number" min="1" name="qty" value="{{ $item['qty'] ?? 1 }}"
                                    class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Status Pembayaran</label>
                                <select name="status_pembayaran" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                                    <option value="Belum Bayar" {{ (($item['status_pembayaran'] ?? '') === 'Belum Bayar') ? 'selected' : '' }}>Belum Bayar</option>
                                    <option value="DP" {{ (($item['status_pembayaran'] ?? '') === 'DP') ? 'selected' : '' }}>DP</option>
                                    <option value="Lunas" {{ (($item['status_pembayaran'] ?? '') === 'Lunas') ? 'selected' : '' }}>Lunas</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-1 text-xs font-medium text-slate-800">Status Transaksi</label>
                                <select name="status_transaksi" class="bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200">
                                    <option value="Booking" {{ (($item['status_transaksi'] ?? '') === 'Booking') ? 'selected' : '' }}>Booking</option>
                                    <option value="Dikembalikan" {{ (($item['status_transaksi'] ?? '') === 'Dikembalikan') ? 'selected' : '' }}>Dikembalikan</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" data-modal-hide="editRentalModal{{ $item['id'] }}"
                                class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-xl hover:bg-slate-200 transition-all duration-300">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                                Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection