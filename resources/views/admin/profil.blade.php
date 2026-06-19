@extends('pelanggan.layouts.app')

@php
    $title = 'Profil Saya - LensCamp';
    $headerTitle = 'Profil Saya';
    $headerDesc = 'Kelola data profil akun Anda';

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]';
    $labelClass = 'mb-2 block text-sm font-medium text-slate-700';
@endphp

@section('content')
<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

    <div class="xl:col-span-1">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-[#2F5249] text-4xl font-bold text-white">
                {{ strtoupper(substr($profil['nama'] ?? session('user') ?? 'P', 0, 1)) }}
            </div>

            <div class="mt-5 text-center">
                <h3 class="text-xl font-bold text-[#2F5249]">
                    {{ $profil['nama'] ?? 'Pelanggan LensCamp' }}
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $profil['email'] ?? session('user') }}
                </p>
            </div>

            <div class="mt-6 space-y-4">
                <div class="rounded-2xl bg-[#F8FAF7] p-5">
                    <p class="text-sm text-slate-500">Status Akun</p>
                    <p class="mt-2 text-base font-bold text-slate-800">
                        {{ $profil['status'] ?? 'Aktif' }}
                    </p>
                </div>

                <div class="rounded-2xl bg-[#F8FAF7] p-5">
                    <p class="text-sm text-slate-500">Member Sejak</p>
                    <p class="mt-2 text-base font-bold text-slate-800">
                        {{ $profil['member_sejak'] ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="xl:col-span-2">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-[#2F5249]">Edit Profil</h3>
            <p class="mt-2 text-sm text-slate-500">
                Perbarui data profil kamu kapan saja.
            </p>

            @if(session('success'))
                <div class="mt-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pelanggan.profil.update') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label class="{{ $labelClass }}">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $profil['nama'] ?? '') }}"
                        class="{{ $inputClass }}"
                        required
                    >
                </div>

                <div>
                    <label class="{{ $labelClass }}">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $profil['email'] ?? session('user')) }}"
                        class="{{ $inputClass }}"
                        required
                    >
                </div>

                <div>
                    <label class="{{ $labelClass }}">No WhatsApp</label>
                    <input
                        type="text"
                        name="no_wa"
                        value="{{ old('no_wa', $profil['no_wa'] ?? '') }}"
                        class="{{ $inputClass }}"
                        placeholder="Contoh: 081234567890"
                    >
                </div>

                <div>
                    <label class="{{ $labelClass }}">Alamat</label>
                    <textarea
                        name="alamat"
                        rows="4"
                        class="{{ $inputClass }}"
                        placeholder="Masukkan alamat lengkap"
                    >{{ old('alamat', $profil['alamat'] ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="{{ $labelClass }}">Password Baru</label>
                        <input
                            type="password"
                            name="password"
                            class="{{ $inputClass }}"
                            placeholder="Kosongkan jika tidak diganti"
                        >
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="{{ $inputClass }}"
                            placeholder="Ulangi password baru"
                        >
                    </div>
                </div>

                <button type="submit"
                    class="rounded-2xl bg-[#2F5249] px-6 py-4 text-sm font-semibold text-white hover:bg-[#437057] transition">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection