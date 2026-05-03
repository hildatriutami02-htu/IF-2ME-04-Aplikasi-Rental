@extends('pelanggan.layouts.app')

@php
    $title = 'Produk - LensCamp';
    $headerTitle = 'Produk';
    $headerDesc = 'Lihat dan sewa perlengkapan terbaik untuk kebutuhan kamu';

    $products = $products ?? [];

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500';

    $filters = [
        [
            'label' => 'Cari Produk',
            'type' => 'input',
            'placeholder' => 'Cari produk...',
        ],
        [
            'label' => 'Kategori',
            'type' => 'select',
            'options' => ['Semua Kategori','Tenda','Tas','Aksesoris'],
        ],
        [
            'label' => 'Urutkan',
            'type' => 'select',
            'options' => ['Urutkan','Harga Termurah','Harga Termahal','Stok Terbanyak'],
        ],
    ];
@endphp

@section('content')
<div class="space-y-6">

    <section class="rounded-3xl bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-sm">
        <p class="text-sm font-semibold text-blue-100">Katalog Pelanggan</p>
        <h3 class="mt-2 text-2xl font-bold leading-tight">
            Pilih produk terbaik untuk kebutuhan kamu.
        </h3>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-blue-100">
            Jelajahi perlengkapan rental yang tersedia, lalu tambahkan produk ke keranjang sebelum checkout.
        </p>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
            @foreach($filters as $filter)
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">
                        {{ $filter['label'] }}
                    </label>

                    @if($filter['type'] === 'input')
                        <input type="text" placeholder="{{ $filter['placeholder'] }}" class="{{ $inputClass }}">
                    @else
                        <select class="{{ $inputClass }}">
                            @foreach($filter['options'] as $opt)
                                <option>{{ $opt }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($products as $item)

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">

                <div class="h-52 bg-slate-100 overflow-hidden">
                    <img
                        src="{{ asset('images/' . ($item['gambar'] ?? 'default.png')) }}"
                        class="h-full w-full object-contain">
                        alt="{{ $item['nama'] }}"
                    >
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $item['kategori'] }}
                            </span>

                            <h3 class="mt-3 text-lg font-bold text-slate-800">
                                {{ $item['nama'] }}
                            </h3>
                        </div>

                        <span class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ $item['status'] ?? 'Ready' }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        {{ $item['deskripsi'] }}
                    </p>

                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-slate-500">Harga</p>
                            <p class="mt-1 font-bold text-blue-600">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 px-4 py-3">
                            <p class="text-slate-500">Stok</p>
                            <p class="mt-1 font-bold text-slate-800">
                                {{ $item['stok'] }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-3 gap-3">
                        <a href="{{ route('products.detail', $item['id']) }}"
                           class="rounded-2xl bg-slate-100 px-3 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                            Detail
                        </a>

                        <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                            <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                            <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            <input type="hidden" name="qty" value="1">

                            <button
                                type="submit"
                                class="w-full rounded-2xl bg-blue-600 px-3 py-3 text-center text-sm font-semibold text-white hover:bg-blue-700 transition"
                            >
                                Keranjang
                            </button>
                        </form>

                        <a href="{{ route('pelanggan.hubungi-admin') }}"
                           class="rounded-2xl bg-blue-800 px-3 py-3 text-center text-sm font-semibold text-white hover:bg-blue-900 transition">
                            Tanya
                        </a>
                    </div>
                </div>

            </div>

        @empty
            <div class="col-span-full rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">
                <h3 class="text-2xl font-bold text-slate-800">Produk belum tersedia</h3>
                <p class="mt-2 text-sm text-slate-500">
                    Saat ini belum ada produk yang bisa ditampilkan.
                </p>
            </div>
        @endforelse
    </section>

</div>
@endsection