@extends('admin.dashboard-admin')

@section('title', 'Update Barang - LensCamp')
@section('page_title', 'Update Barang')
@section('page_desc', 'Edit data produk rental')

@section('content')
@php
    $inputClass = 'bg-[#F8FAF7] border border-[#dfe7df] text-sm rounded-xl block w-full p-3 focus:ring-4 focus:ring-[#DDE8DF] focus:border-[#2F5249]';
@endphp

<div class="max-w-5xl mx-auto">

    <div class="rounded-3xl border border-[#dfe7df] bg-white p-6 shadow-sm">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div>
                    @if(!empty($product->gambar))
                        @php
                            $gambar = str_starts_with($product->gambar, 'products/')
                                ? asset('storage/' . $product->gambar)
                                : asset('images/' . $product->gambar);
                        @endphp

                        <img src="{{ $gambar }}"
                             alt="{{ $product->nama_barang }}"
                             class="w-full h-64 object-contain bg-white p-3 rounded-2xl border border-[#dfe7df]">
                    @else
                        <div class="h-64 rounded-2xl bg-[#F8FAF7] flex items-center justify-center text-6xl font-bold text-[#2F5249]">
                            {{ strtoupper(substr($product->nama_barang, 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Kode Barang</label>
                        <input type="text" name="kode_barang" value="{{ old('kode_barang', $product->kode_barang) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Jenis Barang</label>
                        <select name="jenis_barang" class="{{ $inputClass }}" required>
                            <option value="Kamera" {{ old('jenis_barang', $product->jenis_barang) == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                            <option value="Camping" {{ old('jenis_barang', $product->jenis_barang) == 'Camping' ? 'selected' : '' }}>Camping</option>
                            <option value="Alat Camping" {{ old('jenis_barang', $product->jenis_barang) == 'Alat Camping' ? 'selected' : '' }}>Alat Camping</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Nama Barang</label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Status</label>
                        <select name="status" class="{{ $inputClass }}">
                            <option value="Ready" {{ old('status', $product->status) == 'Ready' ? 'selected' : '' }}>Ready</option>
                            <option value="Pending" {{ old('status', $product->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disewa" {{ old('status', $product->status) == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Estimasi</label>
                        <input type="text" name="estimasi" value="{{ old('estimasi', $product->estimasi) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Harga</label>
                        <input type="number" min="0" name="harga" value="{{ old('harga', $product->harga) }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Unit</label>
                        <input type="number" min="0" name="unit" value="{{ old('unit', $product->unit) }}" class="{{ $inputClass }}" required>
                    </div>

                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-700">Upload Gambar Baru</label>
                        <input type="file" name="gambar" accept="image/*" class="{{ $inputClass }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1 text-sm font-medium text-slate-700">Keterangan</label>
                        <textarea name="deskripsi" rows="4" class="{{ $inputClass }}" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.products') }}"
                   class="rounded-xl bg-[#eef3ee] px-5 py-3 text-sm font-semibold text-[#2F5249] hover:bg-[#dfe7df]">
                    Batal
                </a>

                <button type="submit"
                        class="rounded-xl bg-[#2F5249] px-5 py-3 text-sm font-semibold text-white hover:bg-[#437057]">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</div>
@endsection