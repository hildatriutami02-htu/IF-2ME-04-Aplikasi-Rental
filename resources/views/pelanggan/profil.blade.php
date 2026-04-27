@extends('pelanggan.layouts.app')

@php
    $title = 'Profil - LensCamp';
    $headerTitle = 'Profil';
    $headerDesc = 'Kelola informasi akun pelanggan kamu';

    $profil = $profil ?? [
        'nama' => 'entingmarpaung7@gmail.com',
        'email' => 'entingmarpaung7@gmail.com',
        'no_wa' => '081234567890',
        'alamat' => 'Batam, Indonesia',
        'member_sejak' => 'Februari 2026',
        'status' => 'Terverifikasi',
    ];

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500';
    $labelClass = 'mb-2 block text-sm font-medium text-slate-700';

    $formFields = [
        [
            'label' => 'Nama Lengkap',
            'name' => 'nama',
            'type' => 'text',
            'value' => $profil['nama'],
            'tag' => 'input',
        ],
        [
            'label' => 'Email',
            'name' => 'email',
            'type' => 'email',
            'value' => $profil['email'],
            'tag' => 'input',
        ],
        [
            'label' => 'No WhatsApp',
            'name' => 'no_wa',
            'type' => 'text',
            'value' => $profil['no_wa'],
            'tag' => 'input',
        ],
        [
            'label' => 'Alamat',
            'name' => 'alamat',
            'value' => $profil['alamat'],
            'rows' => 4,
            'tag' => 'textarea',
        ],
    ];
@endphp

@section('content')
<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <div class="xl:col-span-1">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 text-center shadow-sm">
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

                @foreach ($formFields as $field)
                    <div>
                        <label class="{{ $labelClass }}">{{ $field['label'] }}</label>

                        @if ($field['tag'] === 'textarea')
                            <textarea
                                name="{{ $field['name'] }}"
                                rows="{{ $field['rows'] }}"
                                class="{{ $inputClass }}"
                            >{{ $field['value'] }}</textarea>
                        @else
                            <input
                                type="{{ $field['type'] }}"
                                name="{{ $field['name'] }}"
                                value="{{ $field['value'] }}"
                                class="{{ $inputClass }}"
                            >
                        @endif
                    </div>
                @endforeach

                <div class="rounded-2xl bg-slate-50 px-5 py-4">
                    <p class="text-sm text-slate-500">Member Sejak</p>
                    <p class="mt-1 font-semibold text-slate-800">{{ $profil['member_sejak'] }}</p>
                </div>

                <button
                    type="submit"
                    class="rounded-2xl bg-blue-600 px-6 py-4 text-sm font-semibold text-white hover:bg-blue-700 transition"
                >
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection