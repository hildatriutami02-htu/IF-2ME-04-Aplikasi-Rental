@extends('pelanggan.layouts.app')

@php
    $title = 'Form Sewa - LensCamp';
    $headerTitle = 'Form Sewa';
    $headerDesc = 'Lengkapi data penyewaan produk';
@endphp

@section('content')
@if($errors->any())
    <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="h-44 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-4xl font-bold">
                {{ strtoupper(substr($product['nama_barang'], 0, 1)) }}
            </div>

            <div class="mt-4">
                <h3 class="text-xl font-bold text-slate-800">{{ $product['nama_barang'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $product['jenis_barang'] }}</p>
                <p class="text-sm text-slate-500 mt-3">{{ $product['deskripsi'] }}</p>

                <div class="mt-5 space-y-2 text-sm">
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-slate-500">Harga / hari</span>
                        <span class="font-semibold text-blue-600">
                            Rp {{ number_format($product['harga'], 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-slate-500">Stok</span>
                        <span class="font-semibold text-slate-800">{{ $product['unit'] }}</span>
                    </div>

                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3">
                        <span class="text-slate-500">Status</span>
                        <span class="font-semibold text-slate-800">{{ $product['status'] ?? 'Ready' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-slate-800">Isi Detail Penyewaan</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Tentukan tanggal sewa, jumlah unit, dan catatan tambahan.
                </p>
            </div>

            <form action="{{ route('pelanggan.sewa.store', $product['id']) }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Pinjam</label>
                        <input
                            type="date"
                            name="tanggal_pinjam"
                            value="{{ old('tanggal_pinjam') }}"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Kembali</label>
                        <input
                            type="date"
                            name="tanggal_kembali"
                            value="{{ old('tanggal_kembali') }}"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Unit</label>
                    <input
                        type="number"
                        name="qty"
                        min="1"
                        max="{{ $product['unit'] }}"
                        value="{{ old('qty', 1) }}"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                    <textarea
                        name="catatan"
                        rows="4"
                        placeholder="Contoh: minta unit yang paling bagus"
                        class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('catatan') }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button
                        type="submit"
                        class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition"
                    >
                        Ajukan Sewa
                    </button>

                    <a
                        href="{{ route('pelanggan.produk') }}"
                        class="rounded-2xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition"
                    >
                        Kembali ke Produk
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection