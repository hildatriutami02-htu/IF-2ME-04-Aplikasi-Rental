<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->get();

        return view('admin.payments', compact('payments'));
    }

    public function verify($id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'Lunas'
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}