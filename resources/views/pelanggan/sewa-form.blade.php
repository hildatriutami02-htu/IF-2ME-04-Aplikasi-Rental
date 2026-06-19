@extends('pelanggan.layouts.app')

@php
    $title = 'Form Sewa - LensCamp';
    $headerTitle = 'Form Sewa';
    $headerDesc = 'Lengkapi data penyewaan produk';

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]';
    $labelClass = 'block text-sm font-medium text-slate-700 mb-2';

    $productInfo = [
        ['label' => 'Harga / hari', 'value' => 'Rp ' . number_format($product['harga'], 0, ',', '.'), 'valueClass' => 'text-[#2F5249]'],
        ['label' => 'Stok', 'value' => $product['unit'], 'valueClass' => 'text-slate-800'],
        ['label' => 'Status', 'value' => $product['status'] ?? 'Ready', 'valueClass' => 'text-slate-800'],
    ];
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

            <div class="h-44 rounded-2xl bg-[#F8FAF7] flex items-center justify-center text-[#2F5249] text-4xl font-bold">
                {{ strtoupper(substr($product['nama_barang'], 0, 1)) }}
            </div>

            <div class="mt-4">
                <h3 class="text-xl font-bold text-slate-800">{{ $product['nama_barang'] }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $product['jenis_barang'] }}</p>
                <p class="text-sm text-slate-500 mt-3">{{ $product['deskripsi'] }}</p>

                <div class="mt-5 space-y-2 text-sm">
                    @foreach($productInfo as $info)
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8FAF7] px-4 py-3">
                            <span class="text-slate-500">{{ $info['label'] }}</span>
                            <span class="font-semibold {{ $info['valueClass'] }}">
                                {{ $info['value'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-[#2F5249]">Isi Detail Penyewaan</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Tentukan tanggal sewa, jumlah unit, dan catatan tambahan.
                </p>
            </div>

            <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product['id'] }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="{{ $labelClass }}">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" class="{{ $inputClass }}">
                    </div>

                </div>

                <div>
                    <label class="{{ $labelClass }}">Jumlah Unit</label>
                    <input type="number" name="qty" min="1" max="{{ $product['unit'] }}" value="{{ old('qty', 1) }}" class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Catatan</label>
                    <textarea name="catatan" rows="4" placeholder="Contoh: minta unit yang paling bagus" class="{{ $inputClass }}">{{ old('catatan') }}</textarea>
                </div>

                <div class="flex flex-wrap gap-3 pt-2">
                    <button type="submit" class="rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                        Tambah ke Keranjang
                    </button>

                    <a href="{{ route('pelanggan.produk') }}" class="rounded-2xl bg-[#eef3ee] px-6 py-3 text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df] transition">
                        Kembali ke Produk
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection