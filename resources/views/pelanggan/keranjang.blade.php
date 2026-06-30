@extends('pelanggan.layouts.app')

@php
    $title = 'Keranjang - LensCamp';
    $headerTitle = 'Keranjang Rental';
    $headerDesc = 'Atur tanggal, jumlah unit, dan ajukan penyewaan';
@endphp

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(count($keranjang) > 0)
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#eef3ee] text-[#2F5249]">
                        <tr>
                            <th class="p-4 text-left">Produk</th>
                            <th class="p-4 text-center">Tanggal Pinjam</th>
                            <th class="p-4 text-center">Tanggal Kembali</th>
                            <th class="p-4 text-center">Qty</th>
                            <th class="p-4 text-center">Catatan</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($keranjang as $index => $item)
                            <tr class="border-t border-slate-200">
                                <td class="p-4 font-semibold text-slate-800">
                                    {{ $item['nama_barang'] }}
                                    <p class="mt-1 text-xs text-slate-500">
                                        Rp {{ number_format($item['harga_per_hari'], 0, ',', '.') }} / hari
                                    </p>
                                </td>

                                <td class="p-4 text-center">
                                    <form action="{{ route('pelanggan.keranjang.update', $index) }}" method="POST" class="contents">
                                        @csrf

                                        <input
                                            type="date"
                                            name="tanggal_pinjam"
                                            value="{{ $item['tanggal_pinjam'] ?? '' }}"
                                            min="{{ \Carbon\Carbon::today('Asia/Jakarta')->toDateString() }}"
                                            class="tanggal-pinjam rounded-xl border border-slate-300 px-3 py-2 text-sm"
                                            required
                                        >
                                </td>

                                <td class="p-4 text-center">
                                        <input
                                            type="date"
                                            name="tanggal_kembali"
                                            value="{{ $item['tanggal_kembali'] ?? '' }}"
                                            min="{{ \Carbon\Carbon::today('Asia/Jakarta')->toDateString() }}"
                                            class="tanggal-kembali rounded-xl border border-slate-300 px-3 py-2 text-sm"
                                            required
                                        >
                                </td>

                                <td class="p-4 text-center">
                                        <input
                                            type="number"
                                            name="qty"
                                            min="1"
                                            value="{{ $item['qty'] ?? 1 }}"
                                            class="w-20 rounded-xl border border-slate-300 px-3 py-2 text-center text-sm"
                                            required
                                        >
                                </td>

                                <td class="p-4 text-center">
                                        <input
                                            type="text"
                                            name="catatan"
                                            value="{{ $item['catatan'] ?? '' }}"
                                            placeholder="Opsional"
                                            class="rounded-xl border border-slate-300 px-3 py-2 text-sm"
                                        >
                                </td>

                                <td class="p-4 text-center">
                                    <div class="flex justify-center gap-2">
                                        <button type="submit" class="rounded-xl bg-[#2F5249] px-4 py-2 text-sm font-semibold text-white">
                                            Simpan
                                        </button>
                                    </form>

                                    <form action="{{ route('pelanggan.keranjang.hapus', $index) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white">
                                            Hapus
                                        </button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form action="{{ route('pelanggan.keranjang.checkout') }}" method="POST" enctype="multipart/form-data" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf

            <h3 class="text-lg font-bold text-[#2F5249]">Verifikasi Identitas</h3>

            <p class="mt-1 text-sm text-slate-500">
                Upload foto KTP sebagai jaminan dan verifikasi sebelum rental disetujui admin.
            </p>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-semibold text-slate-700">Foto KTP</label>

                <input
                    type="file"
                    name="foto_ktp"
                    accept="image/*"
                    required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 2MB.
                </p>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button type="submit" class="rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                    Checkout / Ajukan Rental
                </button>

                <a href="{{ route('pelanggan.produk') }}" class="rounded-2xl bg-[#eef3ee] px-6 py-3 text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df] transition">
                    Tambah Produk Lain
                </a>
            </div>
        </form>
    @else
        <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <h3 class="text-xl font-bold text-[#2F5249]">Keranjang masih kosong</h3>

            <p class="mt-2 text-sm text-slate-500">
                Silakan pilih produk terlebih dahulu sebelum checkout.
            </p>

            <a href="{{ route('pelanggan.produk') }}" class="mt-6 inline-flex rounded-2xl bg-[#2F5249] px-6 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                Lihat Produk
            </a>
        </div>
    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];

    document.querySelectorAll('.tanggal-pinjam').forEach(function (pinjamInput) {
        const row = pinjamInput.closest('tr');
        const kembaliInput = row.querySelector('.tanggal-kembali');

        pinjamInput.min = today;

        if (pinjamInput.value && pinjamInput.value < today) {
            pinjamInput.value = today;
        }

        if (kembaliInput) {
            kembaliInput.min = pinjamInput.value || today;

            if (kembaliInput.value && kembaliInput.value < kembaliInput.min) {
                kembaliInput.value = kembaliInput.min;
            }
        }

        pinjamInput.addEventListener('change', function () {
            if (kembaliInput) {
                kembaliInput.min = this.value || today;

                if (kembaliInput.value && kembaliInput.value < kembaliInput.min) {
                    kembaliInput.value = kembaliInput.min;
                }
            }
        });
    });
});
</script>
@endsection