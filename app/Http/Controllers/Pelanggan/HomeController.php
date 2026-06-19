<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rental;

class HomeController extends Controller
{
    public function public()
    {
        $isPelanggan = false;
        $isAdmin = false;

        $products = Product::latest()->get();

        $settings = session('website_settings', [
            'nama_website' => 'LensCamp',
            'email_admin' => 'admin.lenscamp@gmail.com',
            'no_whatsapp' => '081291516627',
            'alamat' => 'Batam, Indonesia',
        ]);

        return view('home', compact(
            'isPelanggan',
            'isAdmin',
            'products',
            'settings'
        ));
    }

    public function index()
    {
        $isPelanggan = true;

        // Produk untuk ditampilkan
        $products = Product::latest()->take(6)->get();

        // Total produk tersedia
        $totalProdukTersedia = Product::count();

        // Data rental pelanggan login
        $customerRentals = Rental::where(
            'email',
            session('user')
        )->latest()->get();

        // Total sewa aktif
        $sewaAktif = Rental::where(
            'email',
            session('user')
        )->whereIn('status_transaksi', [
            'Booking',
            'Sedang Disewa',
            'Permintaan Perpanjangan',
            'Menunggu Denda',
        ])->count();

        // Total tagihan belum dibayar
        $tagihan = Rental::where(
            'email',
            session('user')
        )->where('status_pembayaran', 'Belum Bayar')
         ->sum('total_harga');

        // Riwayat pembayaran
        $paymentHistory = Rental::where(
            'email',
            session('user')
        )->whereIn('status_pembayaran', [
            'DP',
            'Lunas'
        ])->get();

        // Pengingat transaksi terakhir
        $pickupReminder = $customerRentals->first();

        $settings = [
            'email_admin' => 'admin.lenscamp@gmail.com',
            'no_whatsapp' => '081291516627',
        ];

        return view('pelanggan.dashboard', compact(
            'isPelanggan',
            'products',
            'customerRentals',
            'paymentHistory',
            'pickupReminder',
            'settings',
            'totalProdukTersedia',
            'sewaAktif',
            'tagihan'
        ));
    }
}