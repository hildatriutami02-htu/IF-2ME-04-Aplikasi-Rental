@extends('admin.dashboard-admin')

@section('title', 'Detail Sewa - LensCamp')
@section('page_title', 'Detail Sewa')
@section('page_desc', 'Informasi detail transaksi penyewaan')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-sm border border-[#dfe7df] p-6">

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-[#2F5249]">
            Detail Transaksi {{ $rental['kode_transaksi'] ?? '-' }}
        </h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Pelanggan</p>
            <p class="font-semibold text-slate-800">{{ $rental['nama_pelanggan'] ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Barang</p>
            <p class="font-semibold text-slate-800">{{ $rental['nama_barang'] ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Qty</p>
            <p class="font-semibold text-slate-800">{{ $rental['qty'] ?? 1 }}</p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Status Transaksi</p>
            <p class="font-semibold text-slate-800">{{ $rental['status_transaksi'] ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Status Pembayaran</p>
            <p class="font-semibold text-slate-800">{{ $rental['status_pembayaran'] ?? '-' }}</p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Total Harga</p>
            <p class="font-semibold text-[#2F5249]">
                Rp {{ number_format((int) ($rental['total_harga'] ?? 0), 0, ',', '.') }}
            </p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Tanggal Pinjam</p>
            <p class="font-semibold text-slate-800">
                {{ $rental['tanggal_pinjam_raw'] ?? $rental['tanggal_pinjam'] ?? '-' }}
            </p>
        </div>

        <div class="rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Tanggal Kembali</p>
            <p class="font-semibold text-slate-800">
                {{ $rental['tanggal_kembali_raw'] ?? $rental['tanggal_kembali'] ?? '-' }}
            </p>
        </div>

        <div class="md:col-span-2 rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500">Catatan</p>
            <p class="font-semibold text-slate-800">
                {{ $rental['catatan'] ?? '-' }}
            </p>
        </div>

        {{-- FOTO KTP --}}
        <div class="md:col-span-2 rounded-2xl bg-[#F8FAF7] p-4">
            <p class="text-slate-500 mb-3">Foto KTP Pelanggan</p>

            @if(!empty($rental->foto_ktp))
                <a href="{{ asset('storage/' . $rental->foto_ktp) }}"
                   target="_blank"
                   class="inline-flex rounded-xl bg-[#2F5249] px-4 py-2 text-sm font-semibold text-white hover:bg-[#437057]">
                    Lihat Ukuran Penuh
                </a>

                <div class="mt-4">
                    <img
                        src="{{ asset('storage/' . $rental->foto_ktp) }}"
                        alt="Foto KTP"
                        class="w-full max-w-lg rounded-xl border border-[#dfe7df] shadow-sm"
                    >
                </div>
            @else
                <div class="rounded-xl bg-red-50 border border-red-200 p-3 text-red-700">
                    Foto KTP belum tersedia.
                </div>
            @endif
        </div>

    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.rentals') }}"
           class="px-5 py-2 rounded-xl bg-[#2F5249] hover:bg-[#437057] text-white text-sm font-semibold">
            Kembali
        </a>
    </div>

</div>
@endsection