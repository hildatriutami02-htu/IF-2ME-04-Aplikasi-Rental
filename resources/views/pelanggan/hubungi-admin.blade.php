@extends('pelanggan.layouts.app')

@php
    $title = 'Bantuan - LensCamp';
    $headerTitle = 'Bantuan';
    $headerDesc = 'Butuh bantuan? Silakan hubungi admin kami';

    $infoCards = [
        [
            'label' => 'Email',
            'value' => 'admin@lenscamp.com',
        ],
        [
            'label' => 'WhatsApp',
            'value' => '081234567890',
        ],
        [
            'label' => 'Jam Operasional',
            'value' => '08:00 - 20:00 WIB',
        ],
    ];

    $inputClass = 'w-full rounded-2xl border border-slate-300 px-5 py-4 text-sm focus:border-blue-500 focus:ring-blue-500';
    $labelClass = 'mb-2 block text-sm font-medium text-slate-700';

    $formFields = [
        [
            'label' => 'Nama',
            'name' => 'nama',
            'type' => 'text',
            'value' => session('user') ?? '',
            'placeholder' => '',
            'tag' => 'input',
        ],
        [
            'label' => 'Email',
            'name' => 'email',
            'type' => 'email',
            'value' => session('user') ?? '',
            'placeholder' => '',
            'tag' => 'input',
        ],
        [
            'label' => 'Subjek',
            'name' => 'subjek',
            'type' => 'text',
            'value' => '',
            'placeholder' => 'Contoh: Kendala Pembayaran',
            'tag' => 'input',
        ],
        [
            'label' => 'Pesan',
            'name' => 'pesan',
            'value' => '',
            'placeholder' => 'Tulis pesan kamu di sini...',
            'rows' => 6,
            'tag' => 'textarea',
        ],
    ];
@endphp

@section('content')
<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
    <div class="xl:col-span-1">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-xl font-bold text-slate-800">Informasi Admin</h3>

            <div class="mt-6 space-y-4">
                @foreach ($infoCards as $card)
                    <div class="rounded-2xl bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                        <p class="mt-2 text-base font-bold text-slate-800">{{ $card['value'] }}</p>
                    </div>
                @endforeach
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

                @foreach ($formFields as $field)
                    <div>
                        <label class="{{ $labelClass }}">{{ $field['label'] }}</label>

                        @if ($field['tag'] === 'textarea')
                            <textarea
                                name="{{ $field['name'] }}"
                                rows="{{ $field['rows'] }}"
                                placeholder="{{ $field['placeholder'] }}"
                                class="{{ $inputClass }}"
                            ></textarea>
                        @else
                            <input
                                type="{{ $field['type'] }}"
                                name="{{ $field['name'] }}"
                                value="{{ $field['value'] }}"
                                placeholder="{{ $field['placeholder'] }}"
                                class="{{ $inputClass }}"
                            >
                        @endif
                    </div>
                @endforeach

                <button type="submit"
                    class="rounded-2xl bg-blue-600 px-6 py-4 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection