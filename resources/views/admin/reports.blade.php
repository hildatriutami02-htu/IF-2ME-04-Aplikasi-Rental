@extends('admin.dashboard-admin')

@section('title', 'Laporan - LensCamp')
@section('page_title', 'Laporan')
@section('page_desc', 'Ringkasan data bisnis LensCamp')

@section('content')
@php
    $summaryCardClass = 'bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-[#437057]';
    $badgeClass = 'px-2.5 py-1 rounded-full text-[11px] font-medium bg-[#DDE8DF] text-[#2F5249]';
@endphp

<div class="max-w-6xl mx-auto space-y-5 animate-fade-up">

    <div class="grid md:grid-cols-3 gap-5">
        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-[#2F5249] mt-2">
                Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
            </h3>
            <div class="mt-4">
                <span class="{{ $badgeClass }}">Akumulasi</span>
            </div>
        </div>

        <div class="{{ $summaryCardClass }}">
            <p class="text-sm text-slate-500">Transaksi Bulan Ini</p>
            <h3 class="text-2xl font-bold text-[#2F5249] mt-2">
                {{ $transaksiBulanIni ?? 0 }}
            </h3>
            <div class="mt-4">
                <span class="{{ $badgeClass }}">Bulan berjalan</span>
            </div>
        </div>

        <div class="{{ $summaryCardClass }}">
           <p class="text-sm text-slate-500">Total Pelanggan</p>
            <h3 class="text-2xl font-bold text-[#2F5249] mt-2">
                {{ $totalPelanggan ?? 0 }}
            </h3>
            <div class="mt-4">
                <span class="{{ $badgeClass }}">Pernah transaksi</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm">
        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="text-xl font-bold text-[#2F5249]">Grafik Pendapatan</h3>
            <p class="text-sm text-slate-500">Grafik pendapatan rental per bulan</p>
        </div>

       <div class="p-5 h-[420px]">
        <canvas id="grafikPendapatan"></canvas>
    </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm">
        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="text-xl font-bold text-[#2F5249]">Laporan Bulanan</h3>
            <p class="text-sm text-slate-500">Ringkasan transaksi per bulan</p>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-[#2F5249] uppercase bg-[#F8FAF7] border-b border-[#dfe7df]">
                    <tr>
                        <th class="px-5 py-4">Bulan</th>
                        <th class="px-5 py-4">Pendapatan</th>
                        <th class="px-5 py-4">Transaksi</th>
                        <th class="px-5 py-4">Produk Disewa</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reportRows as $report)
                        <tr class="bg-white {{ !$loop->last ? 'border-b border-[#dfe7df]' : '' }} hover:bg-[#F8FAF7]">
                            <td class="px-5 py-4">{{ $report['bulan'] }}</td>
                            <td class="px-5 py-4 font-semibold text-[#2F5249]">
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

        <div class="px-5 py-4 border-t border-[#dfe7df] text-sm text-slate-500">
            Data laporan otomatis dari transaksi rental.
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm">
        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="text-xl font-bold text-[#2F5249]">Laporan Per Item Barang</h3>
            <p class="text-sm text-slate-500">Ringkasan rental berdasarkan barang</p>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-sm text-left text-slate-600">
                <thead class="text-xs text-[#2F5249] uppercase bg-[#F8FAF7] border-b border-[#dfe7df]">
                    <tr>
                        <th class="px-5 py-4">Nama Barang</th>
                        <th class="px-5 py-4">Qty Disewa</th>
                        <th class="px-5 py-4">Jumlah Transaksi</th>
                        <th class="px-5 py-4">Pendapatan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reportItems as $item)
                        <tr class="bg-white {{ !$loop->last ? 'border-b border-[#dfe7df]' : '' }} hover:bg-[#F8FAF7]">
                            <td class="px-5 py-4">{{ $item['nama_barang'] }}</td>
                            <td class="px-5 py-4">{{ $item['qty'] }}</td>
                            <td class="px-5 py-4">{{ $item['transaksi'] }}</td>
                            <td class="px-5 py-4 font-semibold text-[#2F5249]">
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
       class="inline-flex items-center gap-2 rounded-xl bg-[#2F5249] px-5 py-3 text-sm font-semibold text-white transition-all duration-300 hover:bg-[#437057] hover:-translate-y-0.5 hover:shadow-md">

        <i class="fa-solid fa-file-pdf"></i>
        Download PDF
    </a>
</div>

</div>

<script type="application/json" id="chartLabels">
    @json($chartLabels ?? [])
</script>

<script type="application/json" id="chartData">
    @json($chartData ?? [])
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('grafikPendapatan');

    const labelBulan = JSON.parse(document.getElementById('chartLabels').textContent);
    const dataPendapatan = JSON.parse(document.getElementById('chartData').textContent);

    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelBulan,
                datasets: [{
                    label: 'Pendapatan',
                    data: dataPendapatan,
                    borderColor: '#2F5249',
                    backgroundColor: 'transparent',
                    borderWidth: 4,
                    tension: 0.3,
                    fill: false,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: '#2F5249',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#eeeeee'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#eeeeee'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
</script>
@endsection