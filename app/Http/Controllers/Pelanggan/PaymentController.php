<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Notification;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('nama_pelanggan', session('nama') ?? session('user'))
            ->orWhere('nama_pelanggan', session('user'))
            ->latest()
            ->get();

        return view('pelanggan.pembayaran', compact('payments'));
    }

  public function uploadBukti(Request $request, $id)
{
    $request->validate([
        'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:5120',
    ], [
        'bukti_bayar.required' => 'Bukti pembayaran wajib diupload.',
        'bukti_bayar.image' => 'File harus berupa gambar.',
        'bukti_bayar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
        'bukti_bayar.max' => 'Ukuran gambar maksimal 5MB.',
    ]);

    $payment = Payment::findOrFail($id);

    $path = $request->file('bukti_bayar')->store('bukti-bayar', 'public');

    $payment->update([
        'bukti_bayar' => $path,
        'status' => 'Menunggu Verifikasi',
        'metode' => 'QRIS',
        'catatan' => 'Pelanggan sudah mengupload bukti pembayaran.',
    ]);

    Notification::create([
        'judul' => 'Bukti Bayar Baru',
        'pesan' => $payment->nama_pelanggan . ' mengupload bukti pembayaran untuk transaksi ' . $payment->kode_transaksi,
        'status' => 'Belum Dibaca',
    ]);

    return redirect()->route('pelanggan.pembayaran')
        ->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
}
}