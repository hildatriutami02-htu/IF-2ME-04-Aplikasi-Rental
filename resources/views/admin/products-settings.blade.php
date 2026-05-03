@extends('admin.dashboard-admin')

@section('title', 'Katalog Sub Barang - LensCamp')
@section('page_title', 'Katalog Sub Barang')
@section('page_desc', 'Kelola setting jenis barang, estimasi, dan status')

@section('content')

@php
    $inputClass = 'w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition';
    $btnPrimary = 'px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition';
    $btnUpdate = 'px-3 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-semibold hover:bg-blue-700 transition';
    $btnDelete = 'px-3 py-1.5 rounded-xl bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100 transition';

    $sections = [
        ['key' => 'jenis_barang', 'title' => 'Jenis Barang'],
        ['key' => 'estimasi', 'title' => 'Estimasi'],
        ['key' => 'status', 'title' => 'Status'],
    ];
@endphp

<div class="max-w-7xl mx-auto animate-fade-up">

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

                    <form action="{{ route('admin.product.settings.store', $section['key']) }}" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">
                                {{ $section['title'] }}
                            </label>

                            <input type="text"
                                   name="nama"
                                   placeholder="Tambah {{ $section['title'] }}"
                                   class="{{ $inputClass }}"
                                   required>
                        </div>

                        <button type="submit" class="{{ $btnPrimary }}">
                            Simpan
                        </button>
                    </form>

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

                                        <td class="px-4 py-3">
                                            {{ $item['nama'] }}
                                        </td>

                                        <td class="px-4 py-3">
                                            <div class="flex justify-center gap-2">

                                                <a href="{{ route('admin.product.settings.edit', ['type' => $section['key'], 'id' => $item['id']]) }}"
                                                   class="{{ $btnUpdate }}">
                                                    Update
                                                </a>

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

</div>
@endsection