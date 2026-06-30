<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class RentalController extends Controller
{
   public function index()
{
    $rentals = Rental::where('email', session('user'))
        ->whereIn('status_transaksi', [
            'Booking',
            'Sedang Disewa',
            'Diperpanjang',
            'Permintaan Perpanjangan',
            'Menunggu Verifikasi',
            'Menunggu Denda',
        ])
        ->latest()
        ->get()
        ->map(function ($rental) {

            $payment = Payment::where('rental_id', $rental->id)->first();

            return [
                'id' => $rental->id,
                'invoice' => $rental->kode_transaksi,
                'produk' => $rental->nama_barang,
                'tanggal_pinjam' => $rental->tanggal_pinjam,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'tanggal_kembali_real' => $rental->tanggal_kembali_real,
                'qty' => $rental->qty,
                'harga' => $rental->total_harga,
                'denda' => $rental->total_denda ?? 0,
                'status' => $rental->status_transaksi,
                'status_pembayaran' => $rental->status_pembayaran,
                'warna' => 'green',

                'payment_id' => $payment->id ?? null,
                'payment_status' => $payment->status ?? null,
                'bukti_bayar' => $payment->bukti_bayar ?? null,
            ];
        });

    return view('pelanggan.sewa', compact('rentals'));
}

    public function extend($id)
    {
        $rental = Rental::where('email', session('user'))
            ->where('id', $id)
            ->firstOrFail();

        return view('pelanggan.sewa-extend', compact('rental'));
    }

    public function extendProses(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
        ]);

        $rental = Rental::where('email', session('user'))
            ->where('id', $id)
            ->firstOrFail();

        $tanggalLama = Carbon::parse($rental->tanggal_kembali);
        $tanggalBaru = Carbon::parse($request->tanggal_kembali);

        $hari = $tanggalLama->diffInDays($tanggalBaru);

        $rental->update([
        'tanggal_kembali' => $request->tanggal_kembali,
        'total_harga' => $hari * ($rental->harga_per_hari ?? 0) * ($rental->qty ?? 1),
        'status_transaksi' => 'Permintaan Perpanjangan',
        'status_pembayaran' => 'Belum Bayar',
        'catatan' => 'Pelanggan mengajukan perpanjangan dari ' .
            $tanggalLama->locale('id')->translatedFormat('d F Y') .
            ' sampai ' .
            $tanggalBaru->locale('id')->translatedFormat('d F Y') .
            '. Durasi tambahan: ' . $hari . ' hari.',
    ]);
        return redirect()->route('pelanggan.sewa')
            ->with('success', 'Sewa berhasil diperpanjang.');
    }

   public function riwayat()
{
    $histories = Rental::where('email', session('user'))
        ->where('status_transaksi', 'Dikembalikan')
        ->latest()
        ->get()
        ->map(function ($rental) {
            return [
                'produk' => $rental->nama_barang,
                'tanggal' => $rental->tanggal_pinjam . ' - ' . $rental->tanggal_kembali,
                'harga' => $rental->total_harga,
                'status' => 'Selesai',
            ];
        });

    return view('pelanggan.riwayat', compact('histories'));
}
}