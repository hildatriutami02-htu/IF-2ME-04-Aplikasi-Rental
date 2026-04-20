@extends('pelanggan.layouts.app')

@php
    $title = 'Beranda - LensCamp';
    $headerTitle = 'Beranda';
    $headerDesc = 'Selamat datang kembali di aplikasi rental kamu';
@endphp

@section('content')
@php
    $stats = [
        ['label' => 'Produk Tersedia', 'value' => 24, 'color' => 'text-slate-800'],
        ['label' => 'Sewa Aktif', 'value' => 3, 'color' => 'text-blue-600'],
        ['label' => 'Tagihan', 'value' => 2, 'color' => 'text-amber-600'],
    ];

    $recentOrders = [
        [
            'produk' => 'Tenda 4 Orang',
            'tanggal' => '12 Apr 2026 - 14 Apr 2026',
            'status' => 'Booking',
            'pembayaran' => 'Belum Bayar',
            'harga' => 200000,
        ],
        [
            'produk' => 'Tripod Kamera',
            'tanggal' => '15 Apr 2026 - 16 Apr 2026',
            'status' => 'Dikembalikan',
            'pembayaran' => 'Lunas',
            'harga' => 55000,
        ],
    ];
@endphp

<div class="space-y-6">
    <section class="rounded-3xl bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-sm">
        <p class="text-sm font-semibold text-blue-100">Halo, {{ session('user') ?? 'Pelanggan' }}</p>
        <h3 class="mt-2 text-2xl font-bold leading-tight">
            Mau sewa perlengkapan apa hari ini?
        </h3>
        <p class="mt-3 max-w-3xl text-sm leading-6 text-blue-100">
            Jelajahi produk, buat pesanan sewa, dan pantau pembayaran kamu dalam satu tempat.
        </p>

        <div class="mt-5 flex flex-wrap gap-3">
            <a href="{{ route('pelanggan.produk') }}"
               class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-slate-100 transition">
                Lihat Produk
            </a>
            <a href="{{ route('pelanggan.sewa') }}"
               class="rounded-2xl bg-blue-700/20 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-blue-700/30 transition">
                Sewa Saya
            </a>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach($stats as $item)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">{{ $item['label'] }}</p>
                <h3 class="mt-2 text-3xl font-bold {{ $item['color'] }}">{{ $item['value'] }}</h3>
            </div>
        @endforeach
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800">Akses Cepat</h3>
            <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">
                <a href="{{ route('pelanggan.produk') }}" class="rounded-2xl bg-slate-100 px-5 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                    Lihat Produk
                </a>
                <a href="{{ route('pelanggan.sewa') }}" class="rounded-2xl bg-slate-100 px-5 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                    Sewa Saya
                </a>
                <a href="{{ route('pelanggan.pembayaran') }}" class="rounded-2xl bg-slate-100 px-5 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                    Pembayaran
                </a>
                <a href="{{ route('pelanggan.hubungi-admin') }}" class="rounded-2xl bg-slate-100 px-5 py-4 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                    Hubungi Admin
                </a>
            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800">Pesanan Terbaru</h3>
            <div class="mt-5 space-y-4">
                @foreach($recentOrders as $order)
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 class="text-base font-bold text-slate-800">{{ $order['produk'] }}</h4>
                                <p class="mt-1 text-sm text-slate-500">{{ $order['tanggal'] }}</p>
                                <p class="mt-2 text-sm font-semibold text-blue-600">
                                    Rp {{ number_format($order['harga'], 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $order['status'] }}
                                </span>
                                <p class="mt-2 text-xs text-slate-500">{{ $order['pembayaran'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection