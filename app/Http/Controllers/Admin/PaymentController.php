<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use App\Models\Product;
use App\Models\Notification;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->get();

        return view('admin.payments', compact('payments'));
    }

    public function verify(int $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'Lunas',
        ]);

        if ($payment->rental_id) {
            Rental::where('id', $payment->rental_id)
                ->update([
                    'status_pembayaran' => 'Lunas',
                    'status_transaksi' => 'Sedang Disewa',
                ]);
        }

        Notification::create([
            'judul' => 'Pembayaran Diverifikasi',
            'pesan' => 'Pembayaran transaksi ' . $payment->kode_transaksi . ' telah diverifikasi admin.',
            'status' => 'Belum Dibaca',
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(int $id)
    {
        $payment = Payment::findOrFail($id);

        $kodeTransaksi = $payment->kode_transaksi;

        if ($payment->rental_id) {
            $rental = Rental::find($payment->rental_id);

            if ($rental) {
                $product = Product::find($rental->product_id);

                if ($product) {
                    $product->increment('unit', $rental->qty ?? 1);

                    $product->update([
                        'status' => 'Tersedia',
                    ]);
                }

                $kodeTransaksi = $rental->kode_transaksi;

                $rental->delete();
            }
        }

        $payment->delete();

        Notification::create([
            'judul' => 'Pembayaran Ditolak',
            'pesan' => 'Bukti pembayaran transaksi ' . $kodeTransaksi . ' ditolak. Pemesanan dibatalkan dan pelanggan harus melakukan pemesanan ulang.',
            'status' => 'Belum Dibaca',
        ]);

        return back()->with(
            'success',
            'Pembayaran ditolak. Pemesanan dibatalkan dan data pembayaran dihapus.'
        );
    }
}