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

    $search = request('search');
    $kategoriAktif = request('kategori');
    $urutkan = request('urutkan', 'terbaru');

    $kategoriProduk = Product::whereIn('jenis_barang', ['Kamera', 'Alat Camping'])
    ->select('jenis_barang')
    ->distinct()
    ->pluck('jenis_barang');

    $produkFavorit = Product::withCount('rentals')
        ->orderByDesc('rentals_count')
        ->take(3)
        ->get();

    $totalProduk = Product::count();

    $totalPelanggan = \App\Models\AkunUser::where('role', 'pelanggan')->count();

    $totalTransaksi = Rental::count();

   $productsQuery = Product::query()
    ->when($search, function ($query) use ($search) {
        $query->where('nama_barang', 'like', '%' . $search . '%');
    })
    ->when($kategoriAktif, function ($query) use ($kategoriAktif) {
        $query->where('jenis_barang', $kategoriAktif);
    });

if ($urutkan === 'termurah') {
    $productsQuery->reorder('harga', 'asc');
} elseif ($urutkan === 'termahal') {
    $productsQuery->reorder('harga', 'desc');
} else {
    $productsQuery->reorder('id', 'desc');
}

$products = $productsQuery->get();

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
    'settings',
    'kategoriProduk',
    'kategoriAktif',
    'produkFavorit',
    'search',
    'urutkan',
    'totalProduk',
    'totalPelanggan',
    'totalTransaksi'
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
            'Diperpanjang',
            'Menunggu Verifikasi',
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