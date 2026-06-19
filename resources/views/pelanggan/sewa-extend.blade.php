@extends('pelanggan.layouts.app')

@php
    $title = 'Perpanjang Sewa - LensCamp';
    $headerTitle = 'Perpanjang Sewa';
    $headerDesc = 'Ubah tanggal kembali untuk transaksi sewa kamu';

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]';
    $labelClass = 'block text-sm font-medium text-slate-700 mb-2';

    $gambarProduk = $product->gambar ?? null;

    $rentalInfo = [
        ['label' => 'Invoice', 'value' => $rental['kode_transaksi'] ?? '-'],
        ['label' => 'Harga / hari', 'value' => 'Rp ' . number_format((int) ($rental['harga_per_hari'] ?? 0), 0, ',', '.')],
        ['label' => 'Qty', 'value' => ($rental['qty'] ?? 1) . ' unit'],
        ['label' => 'Status', 'value' => $rental['status_transaksi'] ?? 'Booking'],
    ];
@endphp

@section('content')

<div class="max-w-5xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

            @if(!empty($gambarProduk))
                <img src="{{ asset('images/' . $gambarProduk) }}"
                     alt="{{ $rental['nama_barang'] ?? 'Produk' }}"
                     class="h-44 w-full rounded-2xl object-contain bg-white border p-3">
            @else
                <div class="h-44 rounded-2xl bg-[#F8FAF7] flex items-center justify-center text-[#2F5249] text-4xl font-bold">
                    {{ strtoupper(substr($rental['nama_barang'] ?? 'S', 0, 1)) }}
                </div>
            @endif

            <div class="mt-4">
                <h3 class="text-xl font-bold text-slate-800">{{ $rental['nama_barang'] ?? '-' }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $rental['nama_pelanggan'] ?? '-' }}</p>
                <p class="text-sm text-slate-500 mt-3">
                    Perpanjang masa sewa dengan memilih tanggal kembali baru yang lebih lama dari tanggal sebelumnya.
                </p>

                <div class="mt-5 space-y-2 text-sm">
                    @foreach($rentalInfo as $info)
                        <div class="flex items-center justify-between rounded-2xl bg-[#F8FAF7] px-4 py-3">
                            <span class="text-slate-500">{{ $info['label'] }}</span>
                            <span class="font-semibold text-slate-800">{{ $info['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-[#2F5249]">Form Perpanjangan</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Pilih tanggal kembali baru, lalu sistem akan menghitung ulang total biaya sewa.
                </p>
            </div>

            <form action="{{ route('pelanggan.sewa.extend.proses', $rental['id']) }}" method="POST" class="space-y-5">
                @csrf

              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="{{ $labelClass }}">Tanggal Pinjam</label>
                    <input
                        type="text"
                        value="{{ !empty($rental['tanggal_pinjam']) ? \Carbon\Carbon::parse($rental['tanggal_pinjam'])->locale('id')->translatedFormat('d F Y') : '-' }}"
                        class="{{ $inputClass }} bg-slate-100"
                        disabled
                    >
                </div>

                <div>
                    <label class="{{ $labelClass }}">Tanggal Kembali Lama</label>
                    <input
                        type="text"
                        value="{{ !empty($rental['tanggal_kembali']) ? \Carbon\Carbon::parse($rental['tanggal_kembali'])->locale('id')->translatedFormat('d F Y') : '-' }}"
                        class="{{ $inputClass }} bg-slate-100"
                        disabled
                    >
                </div>
            </div>

            <div>
                <label class="{{ $labelClass }}">Tanggal Kembali Baru</label>
                <input
                    type="date"
                    name="tanggal_kembali"
                    value="{{ old('tanggal_kembali', !empty($rental['tanggal_kembali_raw']) ? \Carbon\Carbon::parse($rental['tanggal_kembali_raw'])->format('Y-m-d') : '') }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button
                    type="submit"
                    class="rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition"
                >
                    Simpan Perpanjangan
                </button>

                <a
                    href="{{ route('pelanggan.sewa') }}"
                    class="rounded-2xl bg-[#eef3ee] px-6 py-3 text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df] transition"
                >
                    Kembali ke Sewa Saya
                </a>
            </div>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection