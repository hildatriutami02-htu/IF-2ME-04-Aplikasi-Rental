@extends('admin.dashboard-admin')

@section('title', 'Detail Barang - LensCamp')
@section('page_title', 'Detail Barang')
@section('page_desc', 'Lihat detail produk rental')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div>
                @if(!empty($product->gambar))
                    <img src="{{ asset('storage/' . $product->gambar) }}"
                         alt="{{ $product->nama_barang }}"
                         class="w-full h-64 object-contain bg-white p-3 rounded-2xl border">
                @else
                    <div class="h-64 rounded-2xl bg-slate-100 flex items-center justify-center text-6xl font-bold text-slate-400">
                        {{ strtoupper(substr($product->nama_barang, 0, 1)) }}
                    </div>
                @endif
            </div>

            <div class="lg:col-span-2 space-y-4">
                <h1 class="text-3xl font-bold text-slate-800">{{ $product->nama_barang }}</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500">Kode Barang</p>
                        <p class="font-bold">{{ $product->kode_barang ?? '-' }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500">Jenis Barang</p>
                        <p class="font-bold">{{ $product->jenis_barang ?? '-' }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500">Harga</p>
                        <p class="font-bold text-blue-600">
                            Rp {{ number_format($product->harga, 0, ',', '.') }} /Hari
                        </p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500">Unit</p>
                        <p class="font-bold">{{ $product->unit }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500">Status</p>
                        <p class="font-bold">{{ $product->status ?? 'Ready' }}</p>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-slate-500">Estimasi</p>
                        <p class="font-bold">{{ $product->estimasi ?? '-' }}</p>
                    </div>
                </div>

                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-sm text-slate-500">Keterangan</p>
                    <p class="mt-2 text-slate-800">{{ $product->deskripsi ?? '-' }}</p>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.products.edit', $product->id) }}"
                       class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Update
                    </a>

                    <a href="{{ route('admin.products') }}"
                       class="rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection