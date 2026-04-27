@extends('admin.dashboard-admin')

@section('title', 'Update Transaksi Sewa - LensCamp')
@section('page_title', 'Update Transaksi Sewa')
@section('page_desc', 'Perbarui data transaksi penyewaan')

@section('content')

@php
    $inputClass = 'bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200';
    $totalDenda = (int) ($rental['total_denda'] ?? 0);
@endphp

<div class="max-w-5xl mx-auto space-y-4">
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

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Form Update Transaksi</h3>
                <p class="text-sm text-slate-500">Kode: {{ $rental['kode_transaksi'] ?? '-' }}</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.rentals.show', $rental['id']) }}"
                   class="px-4 py-2 rounded-xl bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium">
                    Lihat Detail
                </a>

                <a href="{{ route('admin.rentals') }}"
                   class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>

        <form action="{{ route('admin.rentals.update', $rental['id']) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Pelanggan</label>
                    <input type="text"
                           class="{{ $inputClass }}"
                           value="{{ $rental['nama_pelanggan'] ?? '-' }}"
                           disabled>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Barang</label>
                    <input type="text"
                           class="{{ $inputClass }}"
                           value="{{ $rental['nama_barang'] ?? '-' }}"
                           disabled>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Pinjam</label>
                    <input type="date"
                           name="tanggal_pinjam"
                           class="{{ $inputClass }}"
                           value="{{ old('tanggal_pinjam', $rental['tanggal_pinjam_raw'] ?? '') }}"
                           required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Kembali</label>
                    <input type="date"
                           name="tanggal_kembali"
                           class="{{ $inputClass }}"
                           value="{{ old('tanggal_kembali', $rental['tanggal_kembali_raw'] ?? '') }}"
                           required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Qty</label>
                    <input type="number"
                           min="1"
                           name="qty"
                           class="{{ $inputClass }}"
                           value="{{ old('qty', $rental['qty'] ?? 1) }}"
                           required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Status Pembayaran</label>
                    <select name="status_pembayaran" class="{{ $inputClass }}" required>
                        <option value="Belum Bayar" {{ old('status_pembayaran', $rental['status_pembayaran'] ?? '') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="DP" {{ old('status_pembayaran', $rental['status_pembayaran'] ?? '') == 'DP' ? 'selected' : '' }}>DP</option>
                        <option value="Lunas" {{ old('status_pembayaran', $rental['status_pembayaran'] ?? '') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Status Transaksi</label>
                    <select name="status_transaksi" class="{{ $inputClass }}" required>
                        <option value="Booking" {{ old('status_transaksi', $rental['status_transaksi'] ?? '') == 'Booking' ? 'selected' : '' }}>Booking</option>
                        <option value="Dikembalikan" {{ old('status_transaksi', $rental['status_transaksi'] ?? '') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Kembali Aktual</label>
                    <input type="text"
                           class="{{ $inputClass }}"
                           value="{{ $rental['tanggal_kembali_real'] ?? '-' }}"
                           disabled>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Denda per Hari</label>
                    <input type="text"
                           class="{{ $inputClass }}"
                           value="Rp {{ number_format((int) ($rental['denda_per_hari'] ?? 0), 0, ',', '.') }}"
                           disabled>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Total Denda</label>
                    <input type="text"
                           class="{{ $inputClass }}"
                           value="Rp {{ number_format($totalDenda, 0, ',', '.') }}"
                           disabled>
                </div>

                <div class="md:col-span-2">
                    <label class="block mb-1 text-xs font-medium text-slate-800">Catatan</label>
                    <input type="text"
                           class="{{ $inputClass }}"
                           value="{{ $rental['catatan'] ?? '-' }}"
                           disabled>
                </div>
            </div>

            <div class="flex gap-2 pt-5">
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-600 text-white font-medium text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection