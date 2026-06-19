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

    <div class="bg-white rounded-2xl shadow-sm border border-[#dfe7df] overflow-hidden">
        <div class="px-6 py-4 border-b border-[#dfe7df]">
            <h3 class="text-lg font-bold text-[#2F5249]">Perpanjang Masa Sewa</h3>
            <p class="text-sm text-slate-500 mt-1">Ubah tanggal kembali dan hitung ulang total biaya sewa.</p>
        </div>

        <form action="{{ route('admin.rentals.extend.proses', $rental['id']) }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Kode Transaksi</label>
                    <input type="text"
                        value="{{ $rental['kode_transaksi'] ?? '-' }}"
                        class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7]"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Barang</label>
                    <input type="text"
                        value="{{ $rental['nama_barang'] ?? '-' }}"
                        class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7]"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Tanggal Pinjam</label>
                    <input type="text"
                        value="{{ !empty($rental['tanggal_pinjam']) ? \Carbon\Carbon::parse($rental['tanggal_pinjam'])->format('d-m-Y') : '-' }}"
                        class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7]"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Tanggal Kembali Lama</label>
                    <input type="text"
                        value="{{ !empty($rental['tanggal_kembali']) ? \Carbon\Carbon::parse($rental['tanggal_kembali'])->format('d-m-Y') : '-' }}"
                        class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7]"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Qty</label>
                    <input type="text"
                        value="{{ $rental['qty'] ?? 1 }}"
                        class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7]"
                        disabled>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-700">Harga per Hari</label>
                    <input type="text"
                        value="Rp {{ number_format((int) ($rental['harga_per_hari'] ?? 0), 0, ',', '.') }}"
                        class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7]"
                        disabled>
                </div>
            </div>

            <div>
                <label class="block mb-1 text-sm font-medium text-slate-700">Tanggal Kembali Baru</label>
                <input type="date"
                    name="tanggal_kembali"
                    value="{{ old('tanggal_kembali', $rental['tanggal_kembali_raw'] ?? '') }}"
                    class="w-full rounded-xl border border-[#dfe7df] px-4 py-3 bg-[#F8FAF7] focus:border-[#2F5249] focus:ring-[#2F5249]"
                    required>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#2F5249] hover:bg-[#437057] text-white text-sm font-medium">
                    Simpan Perpanjangan
                </button>

                <a href="{{ route('admin.rentals') }}" class="px-4 py-2 rounded-xl bg-[#eef3ee] hover:bg-[#dfe7df] text-[#2F5249] text-sm font-medium">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection