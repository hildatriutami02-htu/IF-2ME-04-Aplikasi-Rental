@extends('admin.dashboard-admin')

@section('title', 'Pengaturan Website - LensCamp')
@section('page_title', 'Pengaturan Website')
@section('page_desc', 'Atur informasi dasar website')

@section('content')
@php
    $inputClass = 'bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200';
    $labelClass = 'block mb-2 text-sm font-medium text-slate-800';

$settings = $settings ?? [
    'nama_website' => 'LensCamp',
    'email_admin' => 'admin.lenscamp@gmail.com',
    'no_whatsapp' => '081291516627',
    'alamat' => 'Batam, Indonesia',
];
@endphp

<div class="max-w-4xl mx-auto animate-fade-up">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">

        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Form Pengaturan</h3>
            <p class="text-sm text-slate-500">Perbarui informasi dasar website LensCamp</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-5 space-y-5">
            @csrf

            @if (session('success'))
                <div class="p-3 rounded-xl bg-green-50 text-green-700 text-sm border border-green-200">
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
                    value="{{ old('nama_website', $settings['nama_website']) }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Email Admin</label>
                <input
                    type="email"
                    name="email_admin"
                    value="{{ old('email_admin', $settings['email_admin']) }}"
                    class="{{ $inputClass }}"
                    required
                >
            </div>

            <div>
                <label class="{{ $labelClass }}">Nomor WhatsApp</label>
                <input
                    type="text"
                    name="no_whatsapp"
                    value="{{ old('no_whatsapp', $settings['no_whatsapp']) }}"
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
                >{{ old('alamat', $settings['alamat']) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md"
                >
                    Simpan Pengaturan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection