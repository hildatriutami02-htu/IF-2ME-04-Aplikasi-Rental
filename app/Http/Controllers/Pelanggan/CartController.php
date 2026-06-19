<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rental;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    public function index()
    {
        $keranjang = session('keranjang', []);
        return view('pelanggan.keranjang', compact('keranjang'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
        ]);

        $product = Product::findOrFail($request->product_id);

        $keranjang = session('keranjang', []);

        $keranjang[] = [
            'product_id' => $product->id,
            'nama_barang' => $product->nama_barang,
            'harga_per_hari' => $product->harga,
            'qty' => 1,
            'tanggal_pinjam' => null,
            'tanggal_kembali' => null,
            'catatan' => null,
        ];

        session(['keranjang' => $keranjang]);

        return redirect()->route('pelanggan.keranjang')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang. Silakan atur tanggal sewa.');
    }

    public function update(Request $request, $index)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
        ]);

        $keranjang = session('keranjang', []);

        if (!isset($keranjang[$index])) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors('Item tidak ditemukan.');
        }

        $keranjang[$index]['tanggal_pinjam'] = $request->tanggal_pinjam;
        $keranjang[$index]['tanggal_kembali'] = $request->tanggal_kembali;
        $keranjang[$index]['qty'] = $request->qty;
        $keranjang[$index]['catatan'] = $request->catatan;

        session(['keranjang' => $keranjang]);

        return redirect()->route('pelanggan.keranjang')
            ->with('success', 'Keranjang berhasil diperbarui.');
    }

    public function hapus($index)
    {
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$index])) {
            unset($keranjang[$index]);
        }

        session(['keranjang' => array_values($keranjang)]);

        return redirect()->route('pelanggan.keranjang')
            ->with('success', 'Item berhasil dihapus.');
    }

  public function checkout(Request $request)
{
    $request->validate([
        'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $keranjang = session('keranjang', []);

    if (count($keranjang) === 0) {
        return redirect()->route('pelanggan.keranjang')
            ->withErrors('Keranjang masih kosong.');
    }

    foreach ($keranjang as $item) {
        if (empty($item['tanggal_pinjam']) || empty($item['tanggal_kembali'])) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors('Tanggal pinjam dan tanggal kembali wajib diisi.');
        }
    }

    foreach ($keranjang as $item) {
        $product = Product::find($item['product_id']);

        if (!$product) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors('Produk tidak ditemukan.');
        }

        if ($product->unit <= 0) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors('Stok ' . $product->nama_barang . ' sedang habis.');
        }

        if ($product->unit < $item['qty']) {
            return redirect()->route('pelanggan.keranjang')
                ->withErrors('Stok ' . $product->nama_barang . ' hanya tersisa ' . $product->unit . ' unit.');
        }
    }

    $fotoKtp = $request->file('foto_ktp')->store('ktp', 'public');

    foreach ($keranjang as $item) {
        $product = Product::findOrFail($item['product_id']);

        $hari = Carbon::parse($item['tanggal_pinjam'])
            ->diffInDays(Carbon::parse($item['tanggal_kembali'])) + 1;

        $total = $item['harga_per_hari'] * $item['qty'] * $hari;

        $rental = Rental::create([
            'kode_transaksi' => 'TRX-' . time() . rand(10, 99),
            'product_id' => $item['product_id'],
            'nama_pelanggan' => session('nama') ?? session('user') ?? 'Pelanggan',
            'email' => session('user') ?? null,
            'nama_barang' => $item['nama_barang'],
            'qty' => $item['qty'],
            'tanggal_pinjam' => $item['tanggal_pinjam'],
            'tanggal_kembali' => $item['tanggal_kembali'],
            'harga_per_hari' => $item['harga_per_hari'],
            'total_harga' => $total,
            'status_pembayaran' => 'Belum Bayar',
            'status_transaksi' => 'Booking',
            'catatan' => $item['catatan'] ?? null,
            'foto_ktp' => $fotoKtp,
        ]);

        Payment::create([
            'rental_id' => $rental->id,
            'kode_transaksi' => $rental->kode_transaksi,
            'nama_pelanggan' => $rental->nama_pelanggan,
            'nominal' => $rental->total_harga,
            'metode' => 'QRIS Dana',
            'status' => 'Menunggu Verifikasi',
        ]);

        Notification::create([
            'judul' => 'Rental Baru',
            'pesan' => $rental->nama_pelanggan . ' mengajukan rental ' . $rental->nama_barang,
            'status' => 'Belum Dibaca',
        ]);

        $product->decrement('unit', $item['qty']);

        if ($product->fresh()->unit <= 0) {
            $product->update([
                'status' => 'Tidak Tersedia',
            ]);
        }
    }

    session()->forget('keranjang');

    return redirect()->route('pelanggan.sewa')
        ->with('success', 'Rental berhasil diajukan.');
}
}