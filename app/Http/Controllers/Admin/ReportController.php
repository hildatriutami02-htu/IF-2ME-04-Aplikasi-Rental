<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $tahun = now()->year;

        $rentals = Rental::latest()->get();

       $lunasRentals = $rentals->where('status_pembayaran', 'Lunas');

       $totalPendapatan = $lunasRentals->sum('total_harga') + $lunasRentals->sum('total_denda');

        $transaksiBulanIni = Rental::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalPelanggan = $rentals->pluck('email')->filter()->unique()->count();

        $reportRows = $rentals
            ->groupBy(function ($rental) {
                return Carbon::parse($rental->created_at)->locale('id')->translatedFormat('F Y');
            })
            ->map(function ($items, $bulan) {
                $lunas = $items->where('status_pembayaran', 'Lunas');

                return [
                    'bulan' => $bulan,
                    'pendapatan' => $lunas->sum('total_harga') + $lunas->sum('total_denda'),
                    'transaksi' => $items->count(),
                    'produk' => $items->sum('qty'),
                ];
            })
            ->values();

        $reportItems = $rentals
            ->groupBy('nama_barang')
            ->map(function ($items, $namaBarang) {
                return [
                    'nama_barang' => $namaBarang ?: '-',
                    'qty' => $items->sum('qty'),
                    'transaksi' => $items->count(),
                    'pendapatan' =>
                    $items->where('status_pembayaran', 'Lunas')->sum('total_harga')
                    +
                    $items->where('status_pembayaran', 'Lunas')->sum('total_denda'),
                ];
            })
            ->sortByDesc('pendapatan')
            ->values();

        $chartLabels = [];
        $chartData = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $chartLabels[] = Carbon::create($tahun, $bulan, 1)
                ->locale('id')
                ->translatedFormat('M Y');

            $chartData[] =
             Rental::whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->where('status_pembayaran', 'Lunas')
                ->sum('total_harga')

    +

    Rental::whereYear('created_at', $tahun)
        ->whereMonth('created_at', $bulan)
        ->where('status_pembayaran', 'Lunas')
        ->sum('total_denda');
        }

        return view('admin.reports', compact(
            'totalPendapatan',
            'transaksiBulanIni',
            'totalPelanggan',
            'reportRows',
            'reportItems',
            'chartLabels',
            'chartData',
            'tahun'
        ));
    }

    public function pdf()
    {
        $rentals = Rental::latest()->get();

        $lunasRentals = $rentals->where('status_pembayaran', 'Lunas');

        $totalPendapatan = $lunasRentals->sum('total_harga')
            + $lunasRentals->sum('total_denda');

        $reportRows = $rentals
            ->groupBy(function ($rental) {
                return Carbon::parse($rental->created_at)->locale('id')->translatedFormat('F Y');
            })
            ->map(function ($items, $bulan) {
                return [
                    'bulan' => $bulan,
                    'pendapatan' =>
                    $items->where('status_pembayaran', 'Lunas')->sum('total_harga')
                    +
                    $items->where('status_pembayaran', 'Lunas')->sum('total_denda'),
                    'transaksi' => $items->count(),
                    'produk' => $items->sum('qty'),
                ];
            })
            ->values();

        $reportItems = $rentals
            ->groupBy('nama_barang')
            ->map(function ($items, $namaBarang) {
                return [
                    'nama_barang' => $namaBarang ?: '-',
                    'qty' => $items->sum('qty'),
                    'transaksi' => $items->count(),
                    'pendapatan' =>
                    $items->where('status_pembayaran', 'Lunas')->sum('total_harga')
                    +
                    $items->where('status_pembayaran', 'Lunas')->sum('total_denda'),
                ];
            })
            ->sortByDesc('pendapatan')
            ->values();

        return view('admin.reports-pdf', compact(
            'totalPendapatan',
            'reportRows',
            'reportItems'
        ));
    }
}