@extends('pelanggan.layouts.app')

@php
    $title = 'Beranda - LensCamp';
    $headerTitle = 'Beranda';
    $headerDesc = 'Selamat datang kembali di aplikasi rental kamu';

    $heroBg = asset('images/background-camping-camera.jpeg');

    $stats = [
        [
            'label' => 'Produk Tersedia',
            'value' => $totalProdukTersedia ?? 0,
            'color' => 'text-slate-800'
        ],
        [
            'label' => 'Sewa Aktif',
            'value' => $sewaAktif ?? 0,
            'color' => 'text-[#2F5249]'
        ],
        [
            'label' => 'Tagihan',
            'value' => $tagihan ?? 0,
            'color' => 'text-amber-600'
        ],
    ];
@endphp

@section('content')
<div class="space-y-10">

    <section
        class="relative min-h-[360px] overflow-hidden rounded-[32px] bg-cover bg-center px-8 py-12 text-white shadow-xl md:min-h-[420px] md:px-12 md:py-16"
        style="background-image: linear-gradient(rgba(20, 35, 30, .70), rgba(20, 35, 30, .70)), url('{{ $heroBg }}')"
    >
        <div class="max-w-3xl">
            <p class="text-sm font-semibold text-[#DDE8DF]">
                Halo, {{ session('user') ?? 'Pelanggan' }}
            </p>

            <h3 class="mt-3 text-3xl font-extrabold leading-tight md:text-5xl">
                Mau sewa perlengkapan apa hari ini?
            </h3>

            <p class="mt-4 max-w-2xl text-sm leading-7 text-[#F1F6F2] md:text-base">
                Pilih produk langsung dari beranda dan tambahkan ke keranjang.
            </p>

        </div>
    </section>

    <section class="-mt-20 grid grid-cols-1 gap-6 px-4 md:grid-cols-3">
        @foreach($stats as $item)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg">
                <p class="text-sm text-slate-500">{{ $item['label'] }}</p>

                <h3 class="mt-2 text-3xl font-bold {{ $item['color'] }}">
                    @if($item['label'] === 'Tagihan')
                        Rp {{ number_format((int) $item['value'], 0, ',', '.') }}
                    @else
                        {{ $item['value'] }}
                    @endif
                </h3>
            </div>
        @endforeach
    </section>

    <section class="space-y-5">
        <div>
            <h3 class="text-2xl font-bold text-[#2F5249]">
                Produk Tersedia
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Pilih produk dan langsung tambahkan ke keranjang dari sini.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse($products as $item)
                <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">

                    @if(!empty($item->gambar))
                        <img
                            src="{{ asset('images/' . $item->gambar) }}"
                            alt="{{ $item->nama_barang }}"
                            class="h-52 w-full bg-white object-contain p-3"
                        >
                    @else
                        <div class="flex h-52 items-center justify-center bg-[#F8FAF7] text-5xl font-bold text-slate-400">
                            {{ strtoupper(substr($item->nama_barang ?? $item['nama'], 0, 1)) }}
                        </div>
                    @endif

                    <div class="p-5">
                        <h4 class="text-lg font-bold text-slate-800">
                            {{ $item->nama_barang ?? $item['nama'] }}
                        </h4>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ $item->jenis_barang ?? $item['kategori'] }}
                        </p>

                        <p class="mt-3 min-h-[48px] text-sm leading-6 text-slate-500">
                            {{ $item->deskripsi }}
                        </p>

                        <p class="mt-4 text-lg font-bold text-[#2F5249]">
                            Rp {{ number_format($item->harga ?? $item['harga'], 0, ',', '.') }}
                        </p>

                        <div class="mt-5 flex gap-3">
                            <a href="{{ route('products.detail', ['id' => $item->id ?? $item['id'] ?? 0]) }}"
                               class="flex-1 rounded-2xl bg-[#eef3ee] px-4 py-3 text-center text-sm font-semibold text-[#2F5249] transition hover:bg-[#dfe7df]">
                                Detail
                            </a>

                            <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST" class="flex-1">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $item->id ?? $item['id'] }}">
                                <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                <input type="hidden" name="qty" value="1">

                                <button
                                    type="submit"
                                    class="w-full rounded-2xl bg-[#2F5249] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#437057]"
                                >
                                    Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl border border-slate-200 bg-white p-10 text-center text-slate-500">
                    Produk belum tersedia
                </div>
            @endforelse
        </div>

        <div class="flex justify-center pt-4">
            <a href="{{ route('pelanggan.produk') }}"
               class="rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#437057]">
                Lihat Semua Produk
            </a>
        </div>
    </section>

</div>
@endsection