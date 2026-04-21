@extends('pelanggan.layouts.app')

@php
    $title = 'Profil - LensCamp';
    $headerTitle = 'Profil';
    $headerDesc = 'Kelola informasi akun pelanggan kamu';
@endphp

@section('content')
@php
    $profil = $profil ?? [
        'nama' => 'entingmarpaung7@gmail.com',
        'email' => 'entingmarpaung7@gmail.com',
        'no_wa' => '081234567890',
        'alamat' => 'Batam, Indonesia',
        'member_sejak' => 'Februari 2026',
        'status' => 'Terverifikasi',
    ];
@endphp

<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <div class="xl:col-span-1">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm text-center">
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-3xl bg-blue-600 text-4xl font-bold text-white shadow-sm">
                {{ strtoupper(substr($profil['nama'], 0, 1)) }}
            </div>
            <h3 class="mt-5 text-xl font-bold text-slate-800">{{ $profil['nama'] }}</h3>
            <p class="mt-2 text-sm text-slate-500">{{ $profil['email'] }}</p>
            <div class="mt-4 inline-flex rounded-full bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700">
                {{ $profil['status'] }}
            </div>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-slate-800">Informasi Profil</h3>

            <form action="{{ route('pelanggan.profil.update') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $profil['nama'] }}"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" value="{{ $profil['email'] }}"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">No WhatsApp</label>
                    <input type="text" name="no_wa" value="{{ $profil['no_wa'] }}"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Alamat</label>
                    <textarea name="alamat" rows="4"
                        class="w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500">{{ $profil['alamat'] }}</textarea>
                </div>

                <div class="rounded-2xl bg-slate-50 px-5 py-4">
                    <p class="text-sm text-slate-500">Member Sejak</p>
                    <p class="mt-1 font-semibold text-slate-800">{{ $profil['member_sejak'] }}</p>
                </div>

                <button type="submit"
                    class="rounded-2xl bg-blue-600 px-6 py-4 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection