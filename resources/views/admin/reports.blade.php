@extends('admin.dashboard-admin')

@section('title', 'Laporan - LensCamp')
@section('page_title', 'Laporan')
@section('page_desc', 'Ringkasan data bisnis LensCamp')

@section('content')
@php
    $summaryCardClass = 'bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300';
    $badgeClass = 'px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700';
@endphp

<div class="max-w-6xl mx-auto space-y-5 animate-fade-up">

    <div class="grid md:grid-cols-3 gap-5">
        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">
                Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
            </h3>
            <div class="mt-4">
                <span class="{{ $badgeClass }}">Akumulasi</span>
            </div>
        </div>

        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Transaksi Bulan Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">
                {{ $transaksiBulanIni ?? 0 }}
            </h3>
            <div class="mt-4">
                <span class="{{ $badgeClass }}">Bulan berjalan</span>
            </div>
        </div>

        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Pelanggan Aktif</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">
                {{ $pelangganAktif ?? 0 }}
            </h3>
            <div class="mt-4">
                <span class="{{ $badgeClass }}">Terdata aktif</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Grafik Pendapatan</h3>
            <p class="text-sm text-slate-500">Grafik pendapatan rental per bulan</p>
        </div>

        <div class="p-5">
            <canvas id="grafikPendapatan" height="110"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Laporan Bulanan</h3>
            <p class="text-sm text-slate-500">Ringkasan transaksi per bulan</p>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4">Bulan</th>
                        <th class="px-5 py-4">Pendapatan</th>
                        <th class="px-5 py-4">Transaksi</th>
                        <th class="px-5 py-4">Produk Disewa</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reportRows as $report)
                        <tr class="bg-white {{ !$loop->last ? 'border-b border-slate-200' : '' }} hover:bg-slate-50">
                            <td class="px-5 py-4">{{ $report['bulan'] }}</td>
                            <td class="px-5 py-4">
                                Rp {{ number_format($report['pendapatan'], 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4">{{ $report['transaksi'] }}</td>
                            <td class="px-5 py-4">{{ $report['produk'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-6 text-center text-slate-500">
                                Belum ada data laporan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 text-sm text-slate-500">
            Data laporan otomatis dari transaksi rental.
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Laporan Per Item Barang</h3>
            <p class="text-sm text-slate-500">Ringkasan rental berdasarkan barang</p>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-5 py-4">Nama Barang</th>
                        <th class="px-5 py-4">Qty Disewa</th>
                        <th class="px-5 py-4">Jumlah Transaksi</th>
                        <th class="px-5 py-4">Pendapatan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reportItems as $item)
                        <tr class="bg-white {{ !$loop->last ? 'border-b border-slate-200' : '' }} hover:bg-slate-50">
                            <td class="px-5 py-4">{{ $item['nama_barang'] }}</td>
                            <td class="px-5 py-4">{{ $item['qty'] }}</td>
                            <td class="px-5 py-4">{{ $item['transaksi'] }}</td>
                            <td class="px-5 py-4">
                                Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-6 text-center text-slate-500">
                                Belum ada data item barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <a href="{{ route('admin.reports.pdf') }}"
           class="inline-flex rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700 transition">
            Download PDF
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('grafikPendapatan');

    const labelBulan = JSON.parse('{!! json_encode($reportRows->pluck("bulan")->values()) !!}');
    const dataPendapatan = JSON.parse('{!! json_encode($reportRows->pluck("pendapatan")->values()) !!}');

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelBulan,
                datasets: [{
                    label: 'Pendapatan',
                    data: dataPendapatan,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.12)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>
@endsection