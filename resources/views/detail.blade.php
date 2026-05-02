@extends('pelanggan.layouts.app')

@php
    $title = 'Detail Produk - LensCamp';
    $headerTitle = 'Detail Produk';
    $headerDesc = 'Lihat detail produk sebelum menambahkan ke keranjang';

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500';
@endphp

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex h-80 items-center justify-center rounded-2xl bg-slate-100 text-6xl font-bold text-slate-400">
                {{ strtoupper(substr($product->nama_barang, 0, 1)) }}
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                {{ $product->jenis_barang ?? 'Produk' }}
            </span>

            <h1 class="mt-4 text-3xl font-bold text-slate-800">
                {{ $product->nama_barang }}
            </h1>

            <p class="mt-3 text-sm leading-6 text-slate-500">
                {{ $product->deskripsi }}
            </p>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-sm text-slate-500">Harga / Hari</p>
                    <p class="mt-1 font-bold text-blue-600">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                    <p class="text-sm text-slate-500">Stok</p>
                    <p class="mt-1 font-bold text-slate-800">
                        {{ $product->unit }}
                    </p>
                </div>
            </div>

            <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST" class="mt-6 space-y-4">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" required class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" required class="{{ $inputClass }}">
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Jumlah Unit</label>
                    <input type="number" name="qty" min="1" max="{{ $product->unit }}" value="1" required class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Catatan</label>
                    <textarea name="catatan" rows="4" placeholder="Opsional" class="{{ $inputClass }}"></textarea>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button type="submit"
                        class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Tambah ke Keranjang
                    </button>

                    <a href="{{ route('pelanggan.produk') }}"
                       class="rounded-2xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                        Kembali ke Produk
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-slate-800">Syarat Penyewaan</h2>

        <ul class="mt-4 list-disc space-y-2 pl-5 text-sm text-slate-600">
            <li>Wajib membawa atau mengunggah identitas diri.</li>
            <li>Denda keterlambatan berlaku sesuai ketentuan admin.</li>
            <li>Barang harus dikembalikan dalam kondisi baik.</li>
        </ul>
    </div>

</div>
@endsection