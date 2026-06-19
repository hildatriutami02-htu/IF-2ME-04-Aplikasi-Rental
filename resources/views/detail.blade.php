@extends('pelanggan.layouts.app')

@php
    $title = 'Detail Produk - LensCamp';
    $headerTitle = 'Detail Produk';
    $headerDesc = 'Informasi lengkap barang rental LensCamp';
@endphp

@section('content')
<div class="max-w-5xl mx-auto">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @if(!empty($product->gambar))
                <img src="{{ asset('images/' . $product->gambar) }}"
                     alt="{{ $product->nama_barang }}"
                     class="w-full h-80 object-contain bg-white p-4 rounded-2xl">
            @else
                <div class="flex h-80 items-center justify-center rounded-2xl bg-[#F8FAF7] text-6xl font-bold text-[#2F5249]">
                    {{ strtoupper(substr($product->nama_barang, 0, 1)) }}
                </div>
            @endif
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="inline-flex rounded-full bg-[#eef3ee] px-3 py-1 text-xs font-semibold text-[#2F5249]">
                {{ $product->jenis_barang ?? 'Produk' }}
            </span>

            <h1 class="mt-4 text-3xl font-bold text-slate-800">
                {{ $product->nama_barang }}
            </h1>

            <div class="mt-5 grid grid-cols-2 gap-3">
                <div class="rounded-2xl bg-[#F8FAF7] px-4 py-3">
                    <p class="text-sm text-slate-500">Harga / Hari</p>
                    <p class="mt-1 font-bold text-[#2F5249]">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-2xl bg-[#F8FAF7] px-4 py-3">
                    <p class="text-sm text-slate-500">Stok Tersedia</p>
                    <p class="mt-1 font-bold text-slate-800">
                        {{ $product->unit }}
                    </p>
                </div>
            </div>

            <div class="mt-6 rounded-2xl bg-[#F8FAF7] p-5">
                <h2 class="text-lg font-bold text-[#2F5249]">Deskripsi Barang</h2>
                <p class="mt-3 text-sm leading-7 text-slate-600">
                    {{ $product->deskripsi ?? 'Belum ada deskripsi produk.' }}
                </p>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('pelanggan.produk') }}"
                   class="rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                    Kembali ke Produk
                </a>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#2F5249]">Informasi Penyewaan</h2>

        <ul class="mt-4 list-disc space-y-2 pl-5 text-sm text-slate-600">
            <li>Harga sewa dihitung per hari.</li>
            <li>Stok dapat berubah sesuai ketersediaan barang.</li>
            <li>Untuk melakukan penyewaan, silakan kembali ke halaman produk dan tambahkan barang ke keranjang.</li>
        </ul>
    </div>

</div>
@endsection