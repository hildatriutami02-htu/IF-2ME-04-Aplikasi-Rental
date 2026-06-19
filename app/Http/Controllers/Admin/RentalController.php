<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Product;
use App\Models\DataUser;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RentalController extends Controller
{
    private function backToRentals(Request $request, string $message)
    {
        return redirect()->route('admin.rentals', [
            'status' => $request->status_filter ?? 'semua'
        ])->with('success', $message);
    }

    public function index(Request $request)
    {
        $query = Rental::latest();

        if ($request->status && $request->status !== 'semua') {
            $query->where('status_transaksi', $request->status);
        }

        $rentals = $query->get();
        $users = DataUser::latest()->get();
        $products = Product::latest()->get();

        $statusCounts = [
            'Booking' => Rental::where('status_transaksi', 'Booking')->count(),
            'Permintaan Perpanjangan' => Rental::where('status_transaksi', 'Permintaan Perpanjangan')->count(),
            'Sedang Disewa' => Rental::where('status_transaksi', 'Sedang Disewa')->count(),
            'Menunggu Denda' => Rental::where('status_transaksi', 'Menunggu Denda')->count(),
            'Dikembalikan' => Rental::where('status_transaksi', 'Dikembalikan')->count(),
            'Semua' => Rental::count(),
        ];

        return view('admin.rentals', compact(
            'rentals',
            'users',
            'products',
            'statusCounts'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'qty' => 'required|integer|min:1',
            'status_pembayaran' => 'required|string',
            'status_transaksi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $user = DataUser::findOrFail($request->user_id);
        $product = Product::findOrFail($request->product_id);

        $hari = Carbon::parse($request->tanggal_pinjam)
            ->diffInDays(Carbon::parse($request->tanggal_kembali)) + 1;

        $hargaPerHari = $product->harga ?? 0;
        $totalHarga = $hari * $hargaPerHari * $request->qty;

        $rental = Rental::create([
            'kode_transaksi' => 'TRX-' . time(),
            'user_id' => $user->id,
            'product_id' => $product->id,
            'nama_pelanggan' => $user->nama_lengkap,
            'nama_barang' => $product->nama_barang,
            'qty' => $request->qty,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'harga_per_hari' => $hargaPerHari,
            'total_harga' => $totalHarga,
            'status_pembayaran' => $request->status_pembayaran,
            'status_transaksi' => $request->status_transaksi,
            'catatan' => $request->catatan,
        ]);

        Payment::create([
            'rental_id' => $rental->id,
            'kode_transaksi' => $rental->kode_transaksi,
            'nama_pelanggan' => $rental->nama_pelanggan,
            'nominal' => $rental->total_harga,
            'metode' => 'Cash',
            'status' => $request->status_pembayaran === 'Lunas' ? 'Lunas' : 'Menunggu Verifikasi',
        ]);

        Notification::create([
            'judul' => 'Transaksi Admin',
            'pesan' => 'Admin menambahkan transaksi rental untuk ' . $rental->nama_pelanggan,
            'status' => 'Belum Dibaca',
        ]);

        return $this->backToRentals($request, 'Transaksi sewa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rental = Rental::findOrFail($id);
        return view('admin.rental-detail', compact('rental'));
    }

    public function edit($id)
    {
        $rental = Rental::findOrFail($id);
        return view('admin.rental-edit', compact('rental'));
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $data = $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'qty' => 'required|integer|min:1',
            'status_pembayaran' => 'required|string',
            'status_transaksi' => 'required|string',
        ]);

        $hari = Carbon::parse($request->tanggal_pinjam)
            ->diffInDays(Carbon::parse($request->tanggal_kembali)) + 1;

        $hargaPerHari = $rental->harga_per_hari ?? 0;
        $data['total_harga'] = $hari * $hargaPerHari * $request->qty;

        if ($request->status_transaksi === 'Dikembalikan') {
            $data['tanggal_kembali_real'] = now()->toDateString();
        }

        $rental->update($data);

        Payment::where('rental_id', $rental->id)
            ->where('kode_transaksi', $rental->kode_transaksi)
            ->update([
                'nominal' => $data['total_harga'],
                'status' => $request->status_pembayaran === 'Lunas' ? 'Lunas' : 'Menunggu Verifikasi',
            ]);

        Notification::create([
            'judul' => 'Transaksi Diupdate',
            'pesan' => 'Transaksi ' . $rental->kode_transaksi . ' berhasil diupdate admin.',
            'status' => 'Belum Dibaca',
        ]);

        return $this->backToRentals($request, 'Transaksi berhasil diupdate.');
    }

    public function extend($id)
    {
        $rental = Rental::findOrFail($id);
        return view('admin.rental-extend', compact('rental'));
    }

    public function extendProses(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
        ]);

        $rental = Rental::findOrFail($id);

        $hari = Carbon::parse($rental->tanggal_pinjam)
            ->diffInDays(Carbon::parse($request->tanggal_kembali)) + 1;

        $totalHarga = $hari * ($rental->harga_per_hari ?? 0) * ($rental->qty ?? 1);

        $rental->update([
            'tanggal_kembali' => $request->tanggal_kembali,
            'total_harga' => $totalHarga,
        ]);

        Payment::where('rental_id', $rental->id)
            ->where('kode_transaksi', $rental->kode_transaksi)
            ->update([
                'nominal' => $totalHarga,
            ]);

        Notification::create([
            'judul' => 'Sewa Diperpanjang',
            'pesan' => 'Transaksi ' . $rental->kode_transaksi . ' berhasil diperpanjang.',
            'status' => 'Belum Dibaca',
        ]);

        return $this->backToRentals($request, 'Sewa berhasil diperpanjang.');
    }

    public function verify(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        if ($rental->status_transaksi === 'Permintaan Perpanjangan') {
            $rental->update([
                'status_transaksi' => 'Sedang Disewa',
                'status_pembayaran' => 'Lunas',
                'catatan' => ($rental->catatan ?? '') .
                    ' | Perpanjangan disetujui admin pada ' . now()->format('d/m/Y'),
            ]);

            Payment::where('rental_id', $rental->id)->update([
                'status' => 'Lunas',
            ]);

            Notification::create([
                'judul' => 'Perpanjangan Diverifikasi',
                'pesan' => 'Perpanjangan transaksi ' . $rental->kode_transaksi . ' sudah diverifikasi admin.',
                'status' => 'Belum Dibaca',
            ]);

            return $this->backToRentals($request, 'Perpanjangan berhasil diverifikasi.');
        }

        $rental->update([
            'status_transaksi' => 'Sedang Disewa',
            'status_pembayaran' => 'Lunas',
        ]);

        Payment::where('rental_id', $rental->id)->update([
            'status' => 'Lunas',
        ]);

        Notification::create([
            'judul' => 'Pembayaran Diverifikasi',
            'pesan' => 'Transaksi ' . $rental->kode_transaksi . ' sudah diverifikasi admin.',
            'status' => 'Belum Dibaca',
        ]);

        return $this->backToRentals($request, 'Transaksi berhasil diverifikasi.');
    }

    public function returnItem(Request $request, $id)
{
    $rental = Rental::findOrFail($id);

    $today = now();
    $denda = 0;

    if ($today->gt(Carbon::parse($rental->tanggal_kembali))) {
        $hariTerlambat = Carbon::parse($rental->tanggal_kembali)
            ->diffInDays($today);

        $dendaPerHari = $rental->denda_per_hari ?? 25000;
        $denda = $hariTerlambat * $dendaPerHari;
    }

    if ($denda > 0) {
        $rental->update([
            'tanggal_kembali_real' => $today->toDateString(),
            'total_denda' => $denda,
            'status_transaksi' => 'Menunggu Denda',
            'status_pembayaran' => 'Belum Bayar',
        ]);

        Payment::create([
            'rental_id' => $rental->id,
            'kode_transaksi' => $rental->kode_transaksi . '-DENDA',
            'nama_pelanggan' => $rental->nama_pelanggan,
            'nominal' => $denda,
            'metode' => 'Cash',
            'status' => 'Menunggu Verifikasi',
            'catatan' => 'Denda keterlambatan pengembalian barang',
        ]);

        Notification::create([
            'judul' => 'Denda Rental',
            'pesan' => 'Transaksi ' . $rental->kode_transaksi . ' terkena denda Rp ' . number_format($denda, 0, ',', '.'),
            'status' => 'Belum Dibaca',
        ]);

        return $this->backToRentals($request, 'Barang terlambat. Menunggu pembayaran denda.');
    }

    $rental->update([
        'tanggal_kembali_real' => $today->toDateString(),
        'status_transaksi' => 'Dikembalikan',
    ]);

    $product = Product::find($rental->product_id);

    if ($product) {
        $product->increment('unit', $rental->qty ?? 1);

        $product->update([
            'status' => 'Tersedia',
        ]);
    }

    Notification::create([
        'judul' => 'Barang Dikembalikan',
        'pesan' => 'Barang pada transaksi ' . $rental->kode_transaksi . ' sudah dikembalikan.',
        'status' => 'Belum Dibaca',
    ]);

    return $this->backToRentals($request, 'Barang berhasil dikembalikan dan stok sudah diperbarui.');
}

   public function verifyDenda(Request $request, $id)
{
    $rental = Rental::findOrFail($id);

    $rental->update([
        'status_pembayaran' => 'Lunas',
        'status_transaksi' => 'Dikembalikan',
    ]);

    Payment::where('rental_id', $rental->id)
        ->where('kode_transaksi', 'like', '%DENDA%')
        ->update([
            'status' => 'Lunas',
        ]);

    $product = Product::find($rental->product_id);

    if ($product) {
        $product->increment('unit', $rental->qty ?? 1);

        $product->update([
            'status' => 'Tersedia',
        ]);
    }

    Notification::create([
        'judul' => 'Denda Diverifikasi',
        'pesan' => 'Denda transaksi ' . $rental->kode_transaksi . ' sudah lunas dan stok barang sudah dikembalikan.',
        'status' => 'Belum Dibaca',
    ]);

    return $this->backToRentals($request, 'Pembayaran denda berhasil diverifikasi dan stok barang sudah diperbarui.');
}
}