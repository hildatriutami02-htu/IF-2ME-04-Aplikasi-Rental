@extends('admin.dashboard-admin')

@section('title', 'Laporan - LensCamp')
@section('page_title', 'Laporan')
@section('page_desc', 'Ringkasan data bisnis LensCamp')

@section('content')
@php
    $summaryCardClass = 'bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300';
    $badgeClass = 'px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700';

    $summaryCards = [
        [
            'title' => 'Total Pendapatan',
            'value' => 'Rp 12.500.000',
            'badge' => 'Akumulasi',
        ],
        [
            'title' => 'Transaksi Bulan Ini',
            'value' => '48',
            'badge' => 'Bulan berjalan',
        ],
        [
            'title' => 'Pelanggan Aktif',
            'value' => '74',
            'badge' => 'Terdata aktif',
        ],
    ];

    $monthlyReports = [
        [
            'bulan' => 'Januari',
            'pendapatan' => 'Rp 2.500.000',
            'transaksi' => '10',
            'produk' => '18',
        ],
        [
            'bulan' => 'Februari',
            'pendapatan' => 'Rp 3.000.000',
            'transaksi' => '12',
            'produk' => '21',
        ],
        [
            'bulan' => 'Maret',
            'pendapatan' => 'Rp 7.000.000',
            'transaksi' => '26',
            'produk' => '41',
        ],
    ];
@endphp

<div class="max-w-6xl mx-auto space-y-5 animate-fade-up">

    <div class="grid md:grid-cols-3 gap-5">
        @foreach ($summaryCards as $card)
            <div class="{{ $summaryCardClass }}">
                <p class="text-sm text-slate-500">{{ $card['title'] }}</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ $card['value'] }}</h3>
                <div class="mt-4">
                    <span class="{{ $badgeClass }}">{{ $card['badge'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Laporan Bulanan</h3>
            <p class="text-sm text-slate-500">Ringkasan transaksi per bulan</p>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full min-w-[900px] text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4">Bulan</th>
                        <th class="px-5 py-4">Pendapatan</th>
                        <th class="px-5 py-4">Transaksi</th>
                        <th class="px-5 py-4">Produk Disewa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyReports as $index => $report)
                        <tr class="bg-white {{ !$loop->last ? 'border-b border-slate-200' : '' }} hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-5 py-4">{{ $report['bulan'] }}</td>
                            <td class="px-5 py-4">{{ $report['pendapatan'] }}</td>
                            <td class="px-5 py-4">{{ $report['transaksi'] }}</td>
                            <td class="px-5 py-4">{{ $report['produk'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 text-sm text-slate-500">
            Data laporan terakhir diperbarui hari ini.
        </div>
    </div>

</div>
@endsection