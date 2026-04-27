@extends('admin.dashboard-admin')

@section('title', 'Pengaturan Website - LensCamp')
@section('page_title', 'Pengaturan Website')
@section('page_desc', 'Atur informasi dasar website')

@section('content')
@php
    $inputClass = 'bg-slate-50 border border-slate-300 text-slate-800 text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200';
    $labelClass = 'block mb-2 text-sm font-medium text-slate-800';

    $fields = [
        [
            'label' => 'Nama Website',
            'type' => 'text',
            'value' => 'LensCamp',
            'tag' => 'input',
        ],
        [
            'label' => 'Email Admin',
            'type' => 'email',
            'value' => 'admin@lenscamp.com',
            'tag' => 'input',
        ],
        [
            'label' => 'Nomor WhatsApp',
            'type' => 'text',
            'value' => '081234567890',
            'tag' => 'input',
        ],
        [
            'label' => 'Alamat',
            'value' => 'Batam, Indonesia',
            'tag' => 'textarea',
            'rows' => 4,
        ],
    ];
@endphp

<div class="max-w-4xl mx-auto animate-fade-up">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 hover:shadow-md">
        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-xl font-bold text-slate-800">Form Pengaturan</h3>
            <p class="text-sm text-slate-500">Perbarui informasi dasar website LensCamp</p>
        </div>

        <form class="p-5 space-y-5">
            @foreach ($fields as $field)
                <div>
                    <label class="{{ $labelClass }}">{{ $field['label'] }}</label>

                    @if ($field['tag'] === 'textarea')
                        <textarea rows="{{ $field['rows'] }}" class="{{ $inputClass }}">{{ $field['value'] }}</textarea>
                    @else
                        <input type="{{ $field['type'] }}" value="{{ $field['value'] }}" class="{{ $inputClass }}">
                    @endif
                </div>
            @endforeach

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection