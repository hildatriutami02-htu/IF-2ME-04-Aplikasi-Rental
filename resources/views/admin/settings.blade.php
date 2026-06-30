@extends('admin.dashboard-admin')

@section('title', 'Informasi Website - LensCamp')
@section('page_title', 'Informasi Website')
@section('page_desc', 'Kelola informasi website yang ditampilkan kepada pelanggan')

@section('content')
@php
    $inputClass = 'bg-[#F8FAF7] border border-[#dfe7df] text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-[#DDE8DF] focus:border-[#2F5249] transition-all duration-200';
    $labelClass = 'block mb-2 text-sm font-medium text-slate-800';
@endphp

<div class="max-w-3xl mx-auto animate-fade-up">
    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm transition-all duration-300 hover:shadow-md">

        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="text-xl font-bold text-[#2F5249]">Form Informasi Website</h3>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui nama website, email admin, nomor WhatsApp, dan alamat yang tampil pada website.
            </p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-5 space-y-5">
            @csrf

            @if (session('success'))
                <div class="p-3 rounded-xl bg-[#eef3ee] text-[#2F5249] text-sm border border-[#dfe7df]">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-3 rounded-xl bg-red-50 text-red-700 text-sm border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="{{ $labelClass }}">Nama Website</label>
                <input
                    type="text"
                    name="nama_website"
                    value="{{ old('nama_website', $settings->nama_website ?? 'LensCamp') }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Email Admin</label>
                <input
                    type="email"
                    name="email_admin"
                    value="{{ old('email_admin', $settings->email_admin ?? '') }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Nomor WhatsApp</label>
                <input
                    type="text"
                    name="no_whatsapp"
                    value="{{ old('no_whatsapp', $settings->no_whatsapp ?? '') }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Alamat</label>
                <textarea
                    name="alamat"
                    rows="4"
                    class="{{ $inputClass }}"
                    required
                >{{ old('alamat', $settings->alamat ?? '') }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button
                    type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-[#2F5249] rounded-xl hover:bg-[#437057] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection