@extends('admin.dashboard-admin')

@section('title', 'Katalog Sub Barang - LensCamp')
@section('page_title', 'Katalog Sub Barang')
@section('page_desc', 'Kelola setting jenis barang, estimasi, dan status')

@section('content')

@php
    $inputClass = 'w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200';
    $btnPrimary = 'px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md';
    $btnUpdate = 'px-3 py-1.5 rounded-md bg-cyan-500 text-white text-xs hover:bg-cyan-600 transition-all duration-200 hover:-translate-y-0.5';
    $btnDelete = 'px-3 py-1.5 rounded-md bg-red-500 text-white text-xs hover:bg-red-600 transition-all duration-200 hover:-translate-y-0.5';

    $sections = [
        ['key' => 'jenis_barang', 'title' => 'Jenis Barang'],
        ['key' => 'estimasi', 'title' => 'Estimasi'],
        ['key' => 'status', 'title' => 'Status'],
    ];
@endphp

<div class="max-w-7xl mx-auto animate-fade-up">

    {{-- NOTIF --}}
    @if(session('success'))
        <div class="mb-4 rounded-2xl border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition">

        <div class="px-5 py-4 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">Update Sub Barang</h3>
        </div>

        <div class="p-5 grid grid-cols-1 xl:grid-cols-3 gap-6">

            @foreach($sections as $section)
            <div class="space-y-4">

                {{-- FORM --}}
                <form action="{{ route('admin.product.settings.store', $section['key']) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            {{ $section['title'] }}
                        </label>
                        <input type="text" name="nama" placeholder="Tambah {{ $section['title'] }}"
                               class="{{ $inputClass }}">
                    </div>
                    <button type="submit" class="{{ $btnPrimary }}">
                        Simpan
                    </button>
                </form>

                {{-- TABLE --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">{{ $section['title'] }}</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($productSettings[$section['key']] as $index => $item)

                            <tr class="border-t border-slate-200 hover:bg-slate-50 transition">
                                <td class="px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">{{ $item['nama'] }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">
                                        <button type="button"
                                            data-modal-target="edit{{ $section['key'] }}{{ $item['id'] }}"
                                            data-modal-toggle="edit{{ $section['key'] }}{{ $item['id'] }}"
                                            class="{{ $btnUpdate }}">
                                            Update
                                        </button>

                                        <form action="{{ route('admin.product.settings.destroy', ['type' => $section['key'], 'id' => $item['id']]) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="{{ $btnDelete }}">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-slate-500">
                                    Belum ada data.
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
            @endforeach

        </div>
    </div>

    {{-- MODAL (DIPISAH BIAR RAPI) --}}
    @foreach($sections as $section)
        @foreach($productSettings[$section['key']] as $item)

        <div id="edit{{ $section['key'] }}{{ $item['id'] }}"
            class="hidden fixed inset-0 z-50 justify-center items-center bg-slate-900/50 backdrop-blur-sm p-4">

            <div class="w-full max-w-md">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-xl">

                    <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200">
                        <h3 class="text-lg font-bold text-slate-800">
                            Update {{ $section['title'] }}
                        </h3>
                        <button type="button"
                            data-modal-hide="edit{{ $section['key'] }}{{ $item['id'] }}"
                            class="text-slate-400 hover:text-slate-700 hover:bg-slate-100 rounded-lg w-8 h-8">
                            ✕
                        </button>
                    </div>

                    <form action="{{ route('admin.product.settings.update', ['type' => $section['key'], 'id' => $item['id']]) }}"
                          method="POST"
                          class="p-5 space-y-4">
                        @csrf
                        @method('PUT')

                        <input type="text" name="nama" value="{{ $item['nama'] }}"
                               class="{{ $inputClass }}">

                        <div class="flex justify-end gap-3">
                            <button type="button"
                                data-modal-hide="edit{{ $section['key'] }}{{ $item['id'] }}"
                                class="px-4 py-2 rounded-xl bg-slate-200 text-sm hover:bg-slate-300">
                                Batal
                            </button>

                            <button type="submit"
                                class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm hover:bg-blue-700 transition hover:-translate-y-0.5 hover:shadow-md">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @endforeach
    @endforeach

</div>
@endsection