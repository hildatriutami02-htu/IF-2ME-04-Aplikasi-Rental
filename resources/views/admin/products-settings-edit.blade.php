@extends('admin.dashboard-admin')

@section('title', 'Update Sub Barang - LensCamp')
@section('page_title', 'Update Sub Barang')
@section('page_desc', 'Edit data sub barang')

@section('content')
@php
    $inputClass = 'w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500';

    $title = match($type) {
        'jenis_barang' => 'Jenis Barang',
        'estimasi' => 'Estimasi',
        'status' => 'Status',
        default => 'Sub Barang',
    };
@endphp

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <h3 class="text-xl font-bold text-slate-800 mb-5">
            Update {{ $title }}
        </h3>

        <form action="{{ route('admin.product.settings.update', ['type' => $type, 'id' => $id]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2 text-sm font-medium text-slate-700">
                    Nama {{ $title }}
                </label>

                <input type="text"
                       name="nama"
                       value="{{ old('nama', $item['nama']) }}"
                       class="{{ $inputClass }}"
                       required>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.product.settings') }}"
                   class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection