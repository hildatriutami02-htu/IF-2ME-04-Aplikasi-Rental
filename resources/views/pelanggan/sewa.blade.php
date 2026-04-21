@extends('pelanggan.layouts.app')

@php
    $title = 'Sewa Saya - LensCamp';
    $headerTitle = 'Sewa Saya';
    $headerDesc = 'Pantau semua status penyewaan yang sedang berjalan';
@endphp

@section('content')
@php
    $rentals = $rentals ?? [
        [
            'invoice' => 'TRX001',
            'produk' => 'Tenda 4 Orang',
            'tanggal_pinjam' => '12 Apr 2026',
            'tanggal_kembali' => '14 Apr 2026',
            'qty' => 1,
            'harga' => 200000,
            'status' => 'Booking',
            'status_pembayaran' => 'Belum Bayar',
            'warna' => 'blue',
        ],
        [
            'invoice' => 'TRX002',
            'produk' => 'Tripod Kamera',
            'tanggal_pinjam' => '15 Apr 2026',
            'tanggal_kembali' => '16 Apr 2026',
            'qty' => 1,
            'harga' => 55000,
            'status' => 'Dikembalikan',
            'status_pembayaran' => 'Lunas',
            'warna' => 'slate',
        ],
    ];
@endphp

<div class="space-y-6">
    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Transaksi</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ count($rentals) }}</h3>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Sedang Booking</p>
            <h3 class="mt-2 text-3xl font-bold text-blue-600">{{ collect($rentals)->where('status', 'Booking')->count() }}</h3>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Pengeluaran</p>
            <h3 class="mt-2 text-3xl font-bold text-slate-800">Rp {{ number_format(collect($rentals)->sum('harga'), 0, ',', '.') }}</h3>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-sm text-slate-500">
                        <th class="px-4 py-4 font-semibold">Invoice</th>
                        <th class="px-4 py-4 font-semibold">Produk</th>
                        <th class="px-4 py-4 font-semibold">Tanggal Pinjam</th>
                        <th class="px-4 py-4 font-semibold">Tanggal Kembali</th>
                        <th class="px-4 py-4 font-semibold">Qty</th>
                        <th class="px-4 py-4 font-semibold">Biaya</th>
                        <th class="px-4 py-4 font-semibold">Status</th>
                        <th class="px-4 py-4 font-semibold">Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rentals as $item)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-5 text-sm font-semibold text-slate-800">{{ $item['invoice'] }}</td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['produk'] }}</td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['tanggal_pinjam'] }}</td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['tanggal_kembali'] }}</td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['qty'] }}</td>
                            <td class="px-4 py-5 text-sm font-semibold text-blue-600">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td class="px-4 py-5">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item['warna'] === 'blue' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-5 text-sm text-slate-700">{{ $item['status_pembayaran'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection