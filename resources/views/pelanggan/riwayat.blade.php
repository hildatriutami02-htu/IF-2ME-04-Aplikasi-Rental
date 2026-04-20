@extends('pelanggan.layouts.app')

@php
    $title = 'Riwayat Sewa - LensCamp';
    $headerTitle = 'Riwayat';
    $headerDesc = 'Lihat semua transaksi penyewaan yang pernah kamu lakukan';
@endphp

@section('content')
@php
    $histories = $histories ?? [
        [
            'produk' => 'Tripod Kamera',
            'tanggal' => '15 Apr 2026 - 16 Apr 2026',
            'harga' => 55000,
            'status' => 'Selesai',
        ],
        [
            'produk' => 'Tas Slempang',
            'tanggal' => '10 Apr 2026 - 11 Apr 2026',
            'harga' => 12000,
            'status' => 'Selesai',
        ],
    ];
@endphp

<section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    <div class="space-y-4">
        @foreach($histories as $item)
            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ $item['produk'] }}</h3>
                        <p class="mt-2 text-sm text-slate-500">{{ $item['tanggal'] }}</p>
                        <p class="mt-3 text-sm font-semibold text-blue-600">
                            Rp {{ number_format($item['harga'], 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="inline-flex rounded-full bg-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">
                            {{ $item['status'] }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection