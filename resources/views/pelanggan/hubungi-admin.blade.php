@extends('pelanggan.layouts.app')

@php
    $title = 'Bantuan - LensCamp';
    $headerTitle = 'Bantuan';
    $headerDesc = 'Butuh bantuan? Silakan hubungi admin kami';
@endphp

@section('content')
<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <div class="xl:col-span-1">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-slate-800">Informasi Admin</h3>

            <div class="mt-6 space-y-4">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Email</p>
                    <p class="mt-2 text-base font-bold text-slate-800">admin@lenscamp.com</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">WhatsApp</p>
                    <p class="mt-2 text-base font-bold text-slate-800">081234567890</p>
                </div>

                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Jam Operasional</p>
                    <p class="mt-2 text-base font-bold text-slate-800">08:00 - 20:00 WIB</p>
                </div>
            </div>

            <a href="https://wa.me/6281234567890"
               target="_blank"
               class="mt-6 block w-full rounded-2xl bg-blue-600 px-5 py-4 text-center text-sm font-semibold text-white hover:bg-blue-700 transition">
                Chat via WhatsApp
            </a>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-slate-800">Kirim Pesan ke Admin</h3>
            <p class="mt-2 text-sm text-slate-500">
                Isi form di bawah ini jika kamu punya pertanyaan atau kendala.
            </p>

            <form action="{{ route('pelanggan.hubungi-admin.kirim') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Nama</label>
                    <input type="text" name="nama" value="{{ session('user') ?? '' }}"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ session('user') ?? '' }}"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Subjek</label>
                    <input type="text" name="subjek" placeholder="Contoh: Kendala Pembayaran"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Pesan</label>
                    <textarea name="pesan" rows="6" placeholder="Tulis pesan kamu di sini..."
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <button type="submit"
                    class="rounded-2xl bg-blue-600 px-6 py-4 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection