<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use App\Models\Product;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalUser = DataUser::count();
        $totalRental = Rental::count();
        $totalPendapatan = Rental::sum('total_harga');

        $totalMenungguVerifikasi = Rental::where('status_transaksi', 'Menunggu Verifikasi')->count();
        $totalSedangDisewa = Rental::where('status_transaksi', 'Sedang Disewa')->count();
        $totalDikembalikan = Rental::where('status_transaksi', 'Dikembalikan')->count();
        $totalUserAktif = DataUser::count();

        $latestUsers = DataUser::latest()->take(5)->get()->map(function ($user) {
            return [
                'kode' => $user->kode_user ?? 'USR',
                'nama' => $user->name ?? $user->nama_lengkap ?? '-',
                'waktu' => $user->created_at ? $user->created_at->diffForHumans() : '-',
                'status' => 'Aktif',
            ];
        });

        $latestRentals = Rental::latest()->take(5)->get()->map(function ($rental) {
            return [
                'produk' => $rental->nama_barang ?? '-',
                'pelanggan' => $rental->nama_pelanggan ?? '-',
            ];
        });

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalUser',
            'totalRental',
            'totalPendapatan',
            'totalMenungguVerifikasi',
            'totalSedangDisewa',
            'totalDikembalikan',
            'totalUserAktif',
            'latestUsers',
            'latestRentals'
        ));
    }

    public function calendar()
    {
        $rentals = Rental::latest()->get();
        return view('admin.calendar', compact('rentals'));
    }
}