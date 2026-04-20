@extends('admin.dashboard-admin')

@section('title', 'Laporan - LensCamp')
@section('page_title', 'Laporan')
@section('page_desc', 'Ringkasan data bisnis LensCamp')

@section('content')
<div class="max-w-6xl mx-auto space-y-5 animate-fade-up">

    <div class="grid md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300">
            <p class="text-sm text-slate-500">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">Rp 12.500.000</h3>
            <div class="mt-4">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Akumulasi</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300">
            <p class="text-sm text-slate-500">Transaksi Bulan Ini</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">48</h3>
            <div class="mt-4">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Bulan berjalan</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300">
            <p class="text-sm text-slate-500">Pelanggan Aktif</p>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">74</h3>
            <div class="mt-4">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Terdata aktif</span>
            </div>
        </div>
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
                    <tr class="bg-white border-b border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-5 py-4">Januari</td>
                        <td class="px-5 py-4">Rp 2.500.000</td>
                        <td class="px-5 py-4">10</td>
                        <td class="px-5 py-4">18</td>
                    </tr>
                    <tr class="bg-white border-b border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-5 py-4">Februari</td>
                        <td class="px-5 py-4">Rp 3.000.000</td>
                        <td class="px-5 py-4">12</td>
                        <td class="px-5 py-4">21</td>
                    </tr>
                    <tr class="bg-white hover:bg-slate-50 transition-colors duration-200">
                        <td class="px-5 py-4">Maret</td>
                        <td class="px-5 py-4">Rp 7.000.000</td>
                        <td class="px-5 py-4">26</td>
                        <td class="px-5 py-4">41</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-200 text-sm text-slate-500">
            Data laporan terakhir diperbarui hari ini.
        </div>
    </div>

</div>
@endsection