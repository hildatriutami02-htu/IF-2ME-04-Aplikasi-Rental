@extends('pelanggan.layouts.app')

@php
    $title = 'Produk - LensCamp';
    $headerTitle = 'Produk';
    $headerDesc = 'Lihat dan sewa perlengkapan terbaik untuk kebutuhan kamu';

    $products = $products ?? [];

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]';
@endphp

@section('content')
<div class="space-y-6">

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <form method="GET" action="{{ route('pelanggan.produk') }}">
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Cari Produk</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari produk..."
                           class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
                    <select name="kategori" class="{{ $inputClass }}">
                        <option value="">Semua Kategori</option>
                        <option value="Kamera" {{ request('kategori') == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                        <option value="Camping" {{ request('kategori') == 'Camping' ? 'selected' : '' }}>Camping</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Urutkan</label>
                    <select name="sort" class="{{ $inputClass }}">
                        <option value="">Urutkan</option>
                        <option value="murah" {{ request('sort') == 'murah' ? 'selected' : '' }}>Harga Termurah</option>
                        <option value="mahal" {{ request('sort') == 'mahal' ? 'selected' : '' }}>Harga Termahal</option>
                        <option value="stok" {{ request('sort') == 'stok' ? 'selected' : '' }}>Terlaris</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="w-full rounded-2xl bg-[#2F5249] px-4 py-3 text-sm font-semibold text-white hover:bg-[#437057]">
                        Filter
                    </button>

                    <a href="{{ route('pelanggan.produk') }}"
                       class="rounded-2xl bg-[#eef3ee] px-4 py-3 text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df]">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </section>

    <section class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($products as $item)

            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">

                @if(!empty($item->gambar))
                    <img src="{{ asset('images/' . $item->gambar) }}"
                         alt="{{ $item->nama_barang }}"
                         class="w-full h-40 object-contain bg-white p-3 rounded-t-3xl">
                @else
                    <div class="flex h-40 items-center justify-center bg-[#F8FAF7] text-5xl font-bold text-slate-400">
                        {{ strtoupper(substr($item->nama_barang, 0, 1)) }}
                    </div>
                @endif

                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <span class="inline-flex rounded-full bg-[#eef3ee] px-3 py-1 text-xs font-semibold text-[#2F5249]">
                                {{ $item->jenis_barang }}
                            </span>

                            <h3 class="mt-3 text-lg font-bold text-slate-800">
                                {{ $item->nama_barang }}
                            </h3>
                        </div>

                        <span class="inline-flex rounded-full bg-[#F1F6F2] px-3 py-1 text-xs font-semibold text-[#437057]">
                            {{ $item->unit > 0 ? 'Tersedia' : 'Stok Habis' }}
                        </span>
                    </div>

                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        {{ $item->deskripsi }}
                    </p>

                    <div class="mt-5 grid grid-cols-2 gap-3 text-sm">
                        <div class="rounded-2xl bg-[#F8FAF7] px-4 py-3">
                            <p class="text-slate-500">Harga</p>
                            <p class="mt-1 font-bold text-[#2F5249]">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="rounded-2xl bg-[#F8FAF7] px-4 py-3">
                            <p class="text-slate-500">Stok</p>
                            <p class="mt-1 font-bold text-slate-800">
                                {{ $item->unit }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <a href="{{ route('products.detail', $item->id) }}"
                           class="rounded-2xl bg-[#eef3ee] px-3 py-3 text-center text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df] transition">
                            Detail
                        </a>

                        @if($item->unit > 0)
                        <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST">
                            @csrf

                            <input type="hidden" name="product_id" value="{{ $item->id }}">

                            <button type="submit"
                                class="w-full rounded-2xl bg-[#2F5249] px-3 py-3 text-center text-sm font-semibold text-white hover:bg-[#437057] transition">
                                Keranjang
                            </button>
                        </form>
                    @else
                        <button type="button"
                            onclick="alert('Maaf, stok {{ $item->nama_barang }} sedang habis.')"
                            class="w-full cursor-not-allowed rounded-2xl bg-slate-300 px-3 py-3 text-center text-sm font-semibold text-slate-600">
                            Stok Habis
                        </button>
                    @endif
                    </div>
                </div>

            </div>

        @empty
            <div class="col-span-full rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">
                <h3 class="text-2xl font-bold text-[#2F5249]">Produk tidak ditemukan</h3>
                <p class="mt-2 text-sm text-slate-500">
                    Coba ubah kata kunci atau filter kategori.
                </p>
            </div>
        @endforelse
    </section>

</div>
@endsection