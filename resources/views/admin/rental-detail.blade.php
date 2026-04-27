@extends('admin.dashboard-admin')

@section('title', 'Detail Transaksi Sewa - LensCamp')
@section('page_title', 'Detail Transaksi Sewa')
@section('page_desc', 'Informasi lengkap transaksi penyewaan')

@section('content')
@php
    $status = $rental['status_transaksi'] ?? '-';
    $statusClass = $status === 'Dikembalikan'
        ? 'bg-green-100 text-green-700'
        : 'bg-yellow-100 text-yellow-700';

    $payStatus = $rental['status_pembayaran'] ?? '-';
    $payClass = match($payStatus) {
        'DP' => 'bg-yellow-100 text-yellow-700',
        'Lunas' => 'bg-green-100 text-green-700',
        default => 'bg-red-100 text-red-700'
    };

    $totalDenda = (int) ($rental['total_denda'] ?? 0);
@endphp

<div class="max-w-5xl mx-auto space-y-4">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Detail Transaksi</h3>
                <p class="text-sm text-slate-500">Kode: {{ $rental['kode_transaksi'] ?? '-' }}</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.rentals.edit', $rental['id']) }}"
                   class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-600 text-white text-sm font-medium">
                    Update
                </a>

                @if(($rental['status_transaksi'] ?? '') !== 'Dikembalikan')
                    <a href="{{ route('admin.rentals.extend', $rental['id']) }}"
                       class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium">
                        Perpanjang
                    </a>
                @endif

                <a href="{{ route('admin.rentals') }}"
                   class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium">
                    Kembali
                </a>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Kode Transaksi</p>
                <p class="font-semibold text-slate-800">{{ $rental['kode_transaksi'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Nama Pelanggan</p>
                <p class="font-semibold text-slate-800">{{ $rental['nama_pelanggan'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Email</p>
                <p class="font-semibold text-slate-800">{{ $rental['email'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Barang</p>
                <p class="font-semibold text-slate-800">{{ $rental['nama_barang'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Qty</p>
                <p class="font-semibold text-slate-800">{{ $rental['qty'] ?? 1 }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Harga per Hari</p>
                <p class="font-semibold text-slate-800">
                    Rp {{ number_format((int) ($rental['harga_per_hari'] ?? 0), 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Tanggal Pinjam</p>
                <p class="font-semibold text-slate-800">{{ $rental['tanggal_pinjam'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Tanggal Kembali</p>
                <p class="font-semibold text-slate-800">{{ $rental['tanggal_kembali'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Tanggal Kembali Aktual</p>
                <p class="font-semibold text-slate-800">{{ $rental['tanggal_kembali_real'] ?? '-' }}</p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Denda per Hari</p>
                <p class="font-semibold text-slate-800">
                    Rp {{ number_format((int) ($rental['denda_per_hari'] ?? 0), 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Status Pembayaran</p>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $payClass }}">
                    {{ $payStatus }}
                </span>
            </div>

            <div class="rounded-xl border border-slate-200 p-4">
                <p class="text-slate-500 mb-1">Status Transaksi</p>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $statusClass }}">
                    {{ $status }}
                </span>
            </div>

            <div class="rounded-xl border border-slate-200 p-4 md:col-span-2">
                <p class="text-slate-500 mb-1">Total Harga Sewa</p>
                <p class="font-bold text-lg text-slate-800">
                    Rp {{ number_format((int) ($rental['total_harga'] ?? 0), 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4 md:col-span-2">
                <p class="text-slate-500 mb-1">Total Denda</p>
                <p class="font-bold text-lg {{ $totalDenda > 0 ? 'text-red-600' : 'text-slate-800' }}">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 p-4 md:col-span-2">
                <p class="text-slate-500 mb-1">Catatan</p>
                <p class="font-semibold text-slate-800">{{ $rental['catatan'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection