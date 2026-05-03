@extends('pelanggan.layouts.app')

@php
    $title = 'Beranda - LensCamp';
    $headerTitle = 'Beranda';
    $headerDesc = 'Selamat datang kembali di aplikasi rental kamu';

    $stats = [
        ['label' => 'Produk Tersedia', 'value' => count($products ?? []), 'color' => 'text-slate-800'],
        ['label' => 'Sewa Aktif', 'value' => 3, 'color' => 'text-blue-600'],
        ['label' => 'Tagihan', 'value' => 2, 'color' => 'text-amber-600'],
    ];
@endphp

@section('content')
<div class="space-y-6">

    <section class="rounded-3xl bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-sm">
        <p class="text-sm font-semibold text-blue-100">
            Halo, {{ session('user') ?? 'Pelanggan' }}
        </p>

        <h3 class="mt-2 text-2xl font-bold leading-tight">
            Mau sewa perlengkapan apa hari ini?
        </h3>

        <p class="mt-3 max-w-3xl text-sm leading-6 text-blue-100">
            Pilih produk langsung dari beranda dan tambahkan ke keranjang.
        </p>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('pelanggan.produk') }}"
               class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-slate-100 transition">
                Lihat Semua Produk
            </a>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach($stats as $stat)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                <h3 class="mt-2 text-3xl font-bold {{ $stat['color'] }}">
                    {{ $stat['value'] }}
                </h3>
            </div>
        @endforeach
    </section>

    <section class="space-y-5">
        <div>
            <h3 class="text-2xl font-bold text-slate-800">
                Produk Tersedia
            </h3>
            <p class="text-sm text-slate-500 mt-1">
                Pilih produk dan langsung tambahkan ke keranjang dari sini.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($products ?? [] as $item)
                @php
                    $id = $item['id'] ?? 0;
                    $nama = $item['nama_barang'] ?? 'Produk';
                    $kategori = $item['jenis_barang'] ?? '-';
                    $deskripsi = $item['deskripsi'] ?? '-';
                    $harga = $item['harga'] ?? 0;
                @endphp

                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="h-44 overflow-hidden rounded-2xl bg-slate-100">
                            <img src="{{ asset('images/' . $item['gambar']) }}" 
                                alt="{{ $item['nama_barang'] }}"
                                class="h-full w-full object-contain">
                            </div>

                    <h4 class="mt-4 text-lg font-bold text-slate-800">
                        {{ $nama }}
                    </h4>

                    <p class="text-sm text-slate-500">
                        {{ $kategori }}
                    </p>

                    <p class="mt-3 text-sm text-slate-500">
                        {{ $deskripsi }}
                    </p>

                    <p class="mt-3 font-bold text-blue-600">
                        Rp {{ number_format($harga, 0, ',', '.') }}
                    </p>

                    <div class="mt-4 grid grid-cols-3 gap-3">

                        <a href="{{ route('products.detail', ['id' => $id]) }}"
                           class="rounded-xl bg-slate-100 px-3 py-2 text-center text-sm font-semibold text-slate-700">
                            Detail
                        </a>

                        <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $id }}">
                            <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                            <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            <input type="hidden" name="qty" value="1">

                            <button type="submit" class="w-full rounded-xl bg-blue-600 px-3 py-2 text-sm text-white font-semibold">
                                Keranjang
                            </button>
                        </form>

                        <a href="{{ route('pelanggan.hubungi-admin') }}"
                           class="rounded-xl bg-blue-800 px-3 py-2 text-center text-sm text-white font-semibold">
                            Tanya
                        </a>

                    </div>

                </div>

            @empty
                <div class="col-span-full text-center text-slate-500">
                    Produk belum tersedia
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection