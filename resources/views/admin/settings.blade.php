@extends('admin.dashboard-admin')

@section('title', 'Pengaturan Sistem - LensCamp')
@section('page_title', 'Pengaturan Sistem')
@section('page_desc', 'Atur informasi dasar sistem')

@section('content')
@php
    $inputClass = 'bg-[#F8FAF7] border border-[#dfe7df] text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-[#DDE8DF] focus:border-[#2F5249] transition-all duration-200';
    $labelClass = 'block mb-2 text-sm font-medium text-slate-800';
@endphp

<div class="max-w-4xl mx-auto animate-fade-up">
    <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm transition-all duration-300 hover:shadow-md">

        <div class="px-5 py-4 border-b border-[#dfe7df]">
            <h3 class="text-xl font-bold text-[#2F5249]">Form Pengaturan</h3>
            <p class="text-sm text-slate-500">Perbarui informasi dasar website LensCamp</p>
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
                    value="{{ old('nama_website', $settings->nama_website) }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Email Admin</label>
                <input
                    type="email"
                    name="email_admin"
                    value="{{ old('email_admin', $settings->email_admin) }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Nomor WhatsApp</label>
                <input
                    type="text"
                    name="no_whatsapp"
                    value="{{ old('no_whatsapp', $settings->no_whatsapp) }}"
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
                >{{ old('alamat', $settings->alamat) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-[#2F5249] rounded-xl hover:bg-[#437057] transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md"
                >
                    Simpan Pengaturan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection