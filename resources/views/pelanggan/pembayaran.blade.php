@extends('pelanggan.layouts.app')

@php
    $title = 'Pembayaran - LensCamp';
    $headerTitle = 'Pembayaran';
    $headerDesc = 'Lihat status pembayaran dan tagihan kamu';
@endphp

@section('content')
@php
    $payments = $payments ?? [
        [
            'invoice' => 'TRX001',
            'produk' => 'Tenda 4 Orang',
            'tanggal' => '12 Apr 2026',
            'nominal' => 200000,
            'status' => 'Belum Bayar',
            'warna' => 'soft',
        ],
        [
            'invoice' => 'TRX002',
            'produk' => 'Tripod Kamera',
            'tanggal' => '15 Apr 2026',
            'nominal' => 55000,
            'status' => 'Lunas',
            'warna' => 'blue',
        ],
    ];
@endphp

<div class="space-y-6">
    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Tagihan</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-800">
                Rp {{ number_format(collect($payments)->sum('nominal'), 0, ',', '.') }}
            </h3>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Sudah Lunas</p>
            <h3 class="mt-2 text-3xl font-bold text-blue-600">
                {{ collect($payments)->where('status', 'Lunas')->count() }}
            </h3>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Belum Lunas</p>
            <h3 class="mt-2 text-3xl font-bold text-amber-600">
                {{ collect($payments)->where('status', '!=', 'Lunas')->count() }}
            </h3>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-sm text-slate-500">
                        <th class="px-4 py-4 font-semibold">Invoice</th>
                        <th class="px-4 py-4 font-semibold">Produk</th>
                        <th class="px-4 py-4 font-semibold">Tanggal</th>
                        <th class="px-4 py-4 font-semibold">Nominal</th>
                        <th class="px-4 py-4 font-semibold">Status</th>
                        <th class="px-4 py-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $item)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-5 text-sm font-semibold text-slate-800">{{ $item['invoice'] }}</td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['produk'] }}</td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['tanggal'] }}</td>
                            <td class="px-4 py-5 text-sm font-semibold text-blue-600">Rp {{ number_format($item['nominal'], 0, ',', '.') }}</td>
                            <td class="px-4 py-5">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item['warna'] === 'blue' ? 'bg-blue-50 text-blue-700' : 'bg-amber-50 text-amber-700' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-5">
                                <button class="rounded-2xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                                    Bayar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection