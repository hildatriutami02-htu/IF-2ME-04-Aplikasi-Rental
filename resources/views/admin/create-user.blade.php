@extends('admin.dashboard-admin')

@section('title', 'Tambah User')
@section('page_title', 'Tambah User')
@section('page_desc', 'Tambahkan data pengguna baru')

@section('content')
@php
    $inputClass = 'bg-gray-50 border border-gray-300 text-sm rounded-xl block w-full p-3';
    $labelClass = 'block mb-2 text-sm font-medium text-gray-900';
    $fields = [
        [
            'label' => 'Kode User',
            'name' => 'kode_user',
            'type' => 'text',
            'placeholder' => 'USR001',
            'wrapper' => '',
        ],
        [
            'label' => 'No Telp',
            'name' => 'no_telp',
            'type' => 'text',
            'placeholder' => 'Masukkan nomor telepon',
            'wrapper' => '',
        ],
        [
            'label' => 'Nama Lengkap',
            'name' => 'nama_lengkap',
            'type' => 'text',
            'placeholder' => 'Masukkan nama lengkap',
            'wrapper' => '',
        ],
        [
            'label' => 'No WA',
            'name' => 'no_wa',
            'type' => 'text',
            'placeholder' => 'Masukkan nomor WhatsApp',
            'wrapper' => '',
        ],
        [
            'label' => 'No KTP',
            'name' => 'no_ktp',
            'type' => 'text',
            'placeholder' => 'Masukkan nomor KTP',
            'wrapper' => '',
        ],
        [
            'label' => 'Upload Foto KTP',
            'name' => 'foto_ktp',
            'type' => 'file',
            'placeholder' => '',
            'wrapper' => '',
        ],
        [
            'label' => 'Tempat Lahir',
            'name' => 'tempat_lahir',
            'type' => 'text',
            'placeholder' => '',
            'wrapper' => '',
        ],
        [
            'label' => 'Tanggal Lahir',
            'name' => 'tanggal_lahir',
            'type' => 'date',
            'placeholder' => '',
            'wrapper' => '',
        ],
    ];
@endphp

<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-slate-800">Form Tambah User</h3>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach ($fields as $field)
                    <div class="{{ $field['wrapper'] }}">
                        <label class="{{ $labelClass }}">{{ $field['label'] }}</label>

                        @if ($field['type'] === 'file')
                            <input
                                type="file"
                                name="{{ $field['name'] }}"
                                class="{{ $inputClass }}"
                            >
                        @else
                            <input
                                type="{{ $field['type'] }}"
                                name="{{ $field['name'] }}"
                                class="{{ $inputClass }}"
                                placeholder="{{ $field['placeholder'] }}"
                            >
                        @endif
                    </div>
                @endforeach

                <div>
                    <label class="{{ $labelClass }}">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="{{ $inputClass }}">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Alamat</label>
                    <textarea
                        name="alamat"
                        rows="4"
                        class="{{ $inputClass }}"
                        placeholder="Masukkan alamat lengkap"
                    ></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a
                    href="{{ route('admin.users') }}"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection