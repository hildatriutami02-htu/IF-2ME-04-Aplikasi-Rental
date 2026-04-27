@extends('admin.dashboard-admin')

@section('title', 'Perpanjang Sewa - LensCamp')
@section('page_title', 'Perpanjang Sewa')
@section('page_desc', 'Ubah tanggal kembali transaksi')

@section('content')
<div class="max-w-2xl mx-auto">
    @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Perpanjang Masa Sewa</h3>
            <p class="text-sm text-slate-500 mt-1">Ubah tanggal kembali dan hitung ulang total biaya sewa.</p>
        </div>

        <form action="{{ route('admin.rentals.extend.proses', $rental['id']) }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Kode Transaksi</label>
                    <input type="text"
                        value="{{ $rental['kode_transaksi'] ?? '-' }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Barang</label>
                    <input type="text"
                        value="{{ $rental['nama_barang'] ?? '-' }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Tanggal Pinjam</label>
                    <input type="text"
                        value="{{ $rental['tanggal_pinjam'] ?? '-' }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Tanggal Kembali Lama</label>
                    <input type="text"
                        value="{{ $rental['tanggal_kembali'] ?? '-' }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Qty</label>
                    <input type="text"
                        value="{{ $rental['qty'] ?? 1 }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Harga per Hari</label>
                    <input type="text"
                        value="Rp {{ number_format((int) ($rental['harga_per_hari'] ?? 0), 0, ',', '.') }}"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-slate-100"
                        disabled>
                </div>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-slate-700">Tanggal Kembali Baru</label>
                <input type="date"
                    name="tanggal_kembali"
                    value="{{ old('tanggal_kembali', $rental['tanggal_kembali_raw'] ?? '') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3"
                    required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium">
                    Simpan Perpanjangan
                </button>

                <a href="{{ route('admin.rentals') }}" class="px-4 py-2 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection