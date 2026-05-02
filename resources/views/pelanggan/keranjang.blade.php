@extends('pelanggan.layouts.app')

@php
    $title = 'Keranjang - LensCamp';
    $headerTitle = 'Keranjang Rental';
    $headerDesc = 'Daftar produk yang akan diajukan untuk penyewaan';
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

    @if(count($cart) > 0)

        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700">
                        <tr>
                            <th class="p-4 text-left">Produk</th>
                            <th class="p-4 text-center">Tanggal Pinjam</th>
                            <th class="p-4 text-center">Tanggal Kembali</th>
                            <th class="p-4 text-center">Qty</th>
                            <th class="p-4 text-center">Harga / Hari</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($cart as $index => $item)
                            <tr class="border-t border-slate-200">
                                <td class="p-4 font-semibold text-slate-800">
                                    {{ $item['nama_barang'] }}
                                </td>

                                <td class="p-4 text-center text-slate-600">
                                    {{ $item['tanggal_pinjam'] }}
                                </td>

                                <td class="p-4 text-center text-slate-600">
                                    {{ $item['tanggal_kembali'] }}
                                </td>

                                <td class="p-4 text-center text-slate-600">
                                    {{ $item['qty'] }}
                                </td>

                                <td class="p-4 text-center font-semibold text-blue-600">
                                    Rp {{ number_format($item['harga_per_hari'], 0, ',', '.') }}
                                </td>

                                <td class="p-4 text-center">
                                    <form action="{{ route('pelanggan.keranjang.hapus', $index) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <form
            action="{{ route('pelanggan.keranjang.checkout') }}"
            method="POST"
            enctype="multipart/form-data"
            class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm"
        >
            @csrf

            <h3 class="text-lg font-bold text-slate-800">
                Verifikasi Identitas
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                Upload foto KTP sebagai jaminan dan verifikasi sebelum rental disetujui admin.
            </p>

            <div class="mt-5">
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Foto KTP
                </label>

                <input
                    type="file"
                    name="foto_ktp"
                    accept="image/*"
                    required
                    class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                >

                <p class="mt-2 text-xs text-slate-500">
                    Format yang diperbolehkan: JPG, JPEG, PNG. Maksimal 2MB.
                </p>
            </div>

            <div class="mt-6 flex flex-wrap gap-3">
                <button
                    type="submit"
                    class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition"
                >
                    Checkout / Ajukan Rental
                </button>

                <a
                    href="{{ route('pelanggan.produk') }}"
                    class="rounded-2xl bg-slate-100 px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition"
                >
                    Tambah Produk Lain
                </a>
            </div>
        </form>

    @else

        <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">
            <h3 class="text-xl font-bold text-slate-800">Keranjang masih kosong</h3>

            <p class="mt-2 text-sm text-slate-500">
                Silakan pilih produk terlebih dahulu sebelum checkout.
            </p>

            <a
                href="{{ route('pelanggan.produk') }}"
                class="mt-6 inline-flex rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition"
            >
                Lihat Produk
            </a>
        </div>

    @endif

</div>
@endsection