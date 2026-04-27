@extends('admin.dashboard-admin')

@section('title', 'Katalog Barang - LensCamp')
@section('page_title', 'Katalog Barang')
@section('page_desc', 'Kelola produk rental')

@section('content')
@php
    $totalJenis = collect($products)->pluck('jenis_barang')->filter()->unique()->count();
    $totalEstimasi = collect($products)->pluck('estimasi')->filter()->unique()->count();
    $totalStatus = collect($products)->pluck('status')->filter()->unique()->count();
    $totalUnit = collect($products)->sum('unit');

    $inputClass = 'bg-slate-50 border border-slate-300 text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200';
    $cardClass = 'bg-white rounded-2xl border border-slate-200 shadow-sm p-3 flex items-center gap-3 hover:bg-slate-50 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300';
    $actionBtnBase = 'px-3 py-1.5 text-[11px] text-white rounded-md transition-all duration-200 hover:-translate-y-0.5';
    $modalOverlayWhite = 'hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-white/95';
    $modalOverlayDark = 'hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-slate-900/50 backdrop-blur-sm';
    $modalPanelClass = 'relative bg-white rounded-2xl border border-slate-200 shadow-xl';

    $summaryCards = [
        [
            'href' => route('admin.product.settings'),
            'icon' => '⚙',
            'iconClass' => 'bg-cyan-500 text-white',
            'label' => 'Setting Jenis Barang',
            'value' => $totalJenis,
            'clickable' => true,
        ],
        [
            'href' => route('admin.product.settings'),
            'icon' => '📅',
            'iconClass' => 'bg-red-500 text-white',
            'label' => 'Setting Estimasi',
            'value' => $totalEstimasi,
            'clickable' => true,
        ],
        [
            'href' => route('admin.product.settings'),
            'icon' => '🛒',
            'iconClass' => 'bg-green-500 text-white',
            'label' => 'Setting Status',
            'value' => $totalStatus,
            'clickable' => true,
        ],
        [
            'href' => null,
            'icon' => '👥',
            'iconClass' => 'bg-yellow-400 text-slate-900',
            'label' => 'Total Unit',
            'value' => $totalUnit,
            'clickable' => false,
        ],
    ];
@endphp

<div class="max-w-7xl mx-auto space-y-4 animate-fade-up">

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 text-green-800 px-4 py-3 text-sm shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 text-red-800 px-4 py-3 text-sm shadow-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3">
        @foreach($summaryCards as $card)
            @if($card['clickable'])
                <a href="{{ $card['href'] }}" class="{{ $cardClass }}">
                    <div class="w-11 h-11 rounded-xl {{ $card['iconClass'] }} flex items-center justify-center text-lg font-bold shadow-sm">
                        {{ $card['icon'] }}
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                        <h3 class="text-xl font-bold text-slate-800">{{ $card['value'] }}</h3>
                    </div>
                </a>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-3 flex items-center gap-3 transition-all duration-300 hover:shadow-md">
                    <div class="w-11 h-11 rounded-xl {{ $card['iconClass'] }} flex items-center justify-center text-lg font-bold shadow-sm">
                        {{ $card['icon'] }}
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                        <h3 class="text-xl font-bold text-slate-800">{{ $card['value'] }}</h3>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-4 py-3 border-b border-slate-200">
            <h3 class="text-base font-bold text-slate-800">Input Data Barang</h3>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" class="p-4">
            @csrf

            <div class="grid grid-cols-1 xl:grid-cols-4 gap-4">
                <div class="xl:col-span-3 space-y-3">

                    <div class="grid md:grid-cols-3 gap-3">
                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Kode Barang</label>
                            <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" class="{{ $inputClass }}" placeholder="Kode Barang">
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Jenis Barang</label>
                                <select name="jenis_barang" class="{{ $inputClass }}" required>
                                  <option value="">Pilih Jenis Barang</option>
                                  <option value="Kamera" {{ old('jenis_barang') == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                                  <option value="Alat Camping" {{ old('jenis_barang') == 'Alat Camping' ? 'selected' : '' }}>Alat Camping</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Stok</label>
                            <input type="number" min="0" name="unit" value="{{ old('unit') }}" class="{{ $inputClass }}" placeholder="Stok" required>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-3">
                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Nama Barang</label>
                            <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" class="{{ $inputClass }}" placeholder="Nama Barang" required>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Status</label>
                            <select name="status" class="{{ $inputClass }}">
                                <option value="Ready" {{ old('status', 'Ready') == 'Ready' ? 'selected' : '' }}>Ready</option>
                                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="Disewa" {{ old('status') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Estimasi</label>
                            <select name="estimasi" class="{{ $inputClass }}">
                                <option value="1 /Hari" {{ old('estimasi') == '1 /Hari' ? 'selected' : '' }}>1 /Hari</option>
                                <option value="2 /Hari" {{ old('estimasi') == '2 /Hari' ? 'selected' : '' }}>2 /Hari</option>
                                <option value="6 /Hari" {{ old('estimasi') == '6 /Hari' ? 'selected' : '' }}>6 /Hari</option>
                                <option value="12 /Hari" {{ old('estimasi') == '12 /Hari' ? 'selected' : '' }}>12 /Hari</option>
                                <option value="20 /Hari" {{ old('estimasi') == '20 /Hari' ? 'selected' : '' }}>20 /Hari</option>
                                <option value="30 /Hari" {{ old('estimasi') == '30 /Hari' ? 'selected' : '' }}>30 /Hari</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-3">
                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Keterangan</label>
                            <textarea name="deskripsi" rows="2" class="{{ $inputClass }}" placeholder="Keterangan barang" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Harga Sewa</label>
                            <input type="number" min="0" name="harga" value="{{ old('harga') }}" class="{{ $inputClass }}" placeholder="Harga Sewa" required>
                        </div>

                        <div>
                            <label class="block mb-1 text-xs font-medium text-slate-800">Upload Foto Barang</label>
                            <input type="text" name="gambar" value="{{ old('gambar') }}" class="{{ $inputClass }}" placeholder="Link gambar">
                        </div>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                            Simpan
                        </button>
                        <button type="reset" class="px-4 py-2 rounded-xl bg-cyan-500 hover:bg-cyan-600 text-white font-medium text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                            Batalkan
                        </button>
                    </div>
                </div>

                <div class="xl:col-span-1">
                    <div class="border border-slate-200 rounded-2xl p-3 bg-slate-50 min-h-[180px] flex items-center justify-center shadow-sm">
                        <div class="w-24 h-24 border border-slate-200 rounded-xl bg-white flex items-center justify-center text-xs text-slate-400 text-center px-2 shadow-sm">
                            Preview Gambar
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Katalog Barang</h3>
            <span class="text-xs text-slate-500">Data barang rental</span>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full min-w-[1100px] text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-700 bg-slate-50 border-b border-slate-200 uppercase">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Kode Barang</th>
                        <th class="px-4 py-3">Nama Barang</th>
                        <th class="px-4 py-3">Jenis Barang</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Unit</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $index => $item)
                        @php
                            $status = $item['status'] ?? 'Ready';
                            $badgeClass = 'bg-green-100 text-green-700';

                            if (strtolower($status) === 'pending') {
                                $badgeClass = 'bg-yellow-100 text-yellow-700';
                            } elseif (strtolower($status) === 'disewa') {
                                $badgeClass = 'bg-blue-100 text-blue-700';
                            }
                        @endphp

                        <tr class="bg-white border-b border-slate-200 hover:bg-slate-50 transition-colors duration-200">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $item['kode_barang'] ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $item['nama_barang'] ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item['jenis_barang'] ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">Rp. {{ number_format((int) ($item['harga'] ?? 0), 0, ',', '.') }} /Hari</td>
                            <td class="px-4 py-3">{{ $item['unit'] ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center gap-2 whitespace-nowrap">
                                    <button
                                        data-modal-target="detailBarangModal{{ $item['id'] }}"
                                        data-modal-toggle="detailBarangModal{{ $item['id'] }}"
                                        class="{{ $actionBtnBase }} bg-blue-500 hover:bg-blue-600"
                                        type="button"
                                    >
                                        Detail
                                    </button>

                                    <button
                                        data-modal-target="editBarangModal{{ $item['id'] }}"
                                        data-modal-toggle="editBarangModal{{ $item['id'] }}"
                                        class="{{ $actionBtnBase }} bg-cyan-500 hover:bg-cyan-600"
                                        type="button"
                                    >
                                        Update
                                    </button>

                                    <form action="{{ route('admin.products.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="{{ $actionBtnBase }} bg-red-500 hover:bg-red-600"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-slate-500">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t border-slate-200 flex items-center justify-between">
            <span class="text-xs text-slate-500">
                Menampilkan {{ count($products) > 0 ? '1-' . count($products) : '0' }} dari {{ count($products) }} data
            </span>
            <span class="text-xs text-slate-500">Halaman 1</span>
        </div>
    </div>

    {{-- MODAL DI LUAR TABLE --}}
    @foreach($products as $item)
        <div
            id="detailBarangModal{{ $item['id'] }}"
            tabindex="-1"
            aria-hidden="true"
            class="{{ $modalOverlayWhite }}"
        >
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="{{ $modalPanelClass }}">
                    <div class="flex items-center justify-between p-5 border-b border-slate-200 rounded-t">
                        <h3 class="text-xl font-semibold text-slate-900">Detail Barang</h3>
                        <button
                            type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition"
                            data-modal-hide="detailBarangModal{{ $item['id'] }}"
                        >
                            ✕
                        </button>
                    </div>

                    <div class="p-5 space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500">Kode Barang</p>
                                <p class="font-semibold text-slate-800">{{ $item['kode_barang'] ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Nama Barang</p>
                                <p class="font-semibold text-slate-800">{{ $item['nama_barang'] ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Jenis Barang</p>
                                <p class="font-semibold text-slate-800">{{ $item['jenis_barang'] ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Unit</p>
                                <p class="font-semibold text-slate-800">{{ $item['unit'] ?? 0 }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Status</p>
                                <p class="font-semibold text-slate-800">{{ $item['status'] ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500">Estimasi</p>
                                <p class="font-semibold text-slate-800">{{ $item['estimasi'] ?? '-' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-xs text-slate-500">Keterangan</p>
                                <p class="font-semibold text-slate-800">{{ $item['deskripsi'] ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="button"
                                data-modal-hide="detailBarangModal{{ $item['id'] }}"
                                class="px-4 py-2 text-sm font-medium text-white bg-slate-800 rounded-xl hover:bg-slate-900 transition-all duration-300 hover:-translate-y-0.5"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            id="editBarangModal{{ $item['id'] }}"
            tabindex="-1"
            aria-hidden="true"
            class="{{ $modalOverlayDark }}"
        >
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <div class="{{ $modalPanelClass }}">
                    <div class="flex items-center justify-between p-5 border-b border-slate-200 rounded-t">
                        <h3 class="text-xl font-semibold text-slate-900">Update Barang</h3>
                        <button
                            type="button"
                            class="text-slate-400 hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center transition"
                            data-modal-hide="editBarangModal{{ $item['id'] }}"
                        >
                            ✕
                        </button>
                    </div>

                    <form action="{{ route('admin.products.update', $item['id']) }}" method="POST" class="p-5 space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid md:grid-cols-2 gap-3">
                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Kode Barang</label>
                                <input type="text" name="kode_barang" value="{{ $item['kode_barang'] ?? '' }}" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Jenis Barang</label>
                                <select name="jenis_barang" class="{{ $inputClass }}" required>
                                     <option value="Kamera" {{ ($item['jenis_barang'] ?? '') == 'Kamera' ? 'selected' : '' }}>Kamera</option>
                                     <option value="Alat Camping" {{ ($item['jenis_barang'] ?? '') == 'Alat Camping' ? 'selected' : '' }}>Alat Camping</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Nama Barang</label>
                                <input type="text" name="nama_barang" value="{{ $item['nama_barang'] ?? '' }}" class="{{ $inputClass }}" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Status</label>
                                <select name="status" class="{{ $inputClass }}">
                                    <option value="Ready" {{ (($item['status'] ?? '') === 'Ready') ? 'selected' : '' }}>Ready</option>
                                    <option value="Pending" {{ (($item['status'] ?? '') === 'Pending') ? 'selected' : '' }}>Pending</option>
                                    <option value="Disewa" {{ (($item['status'] ?? '') === 'Disewa') ? 'selected' : '' }}>Disewa</option>
                                </select>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Estimasi</label>
                                <input type="text" name="estimasi" value="{{ $item['estimasi'] ?? '' }}" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Harga</label>
                                <input type="number" min="0" name="harga" value="{{ $item['harga'] ?? 0 }}" class="{{ $inputClass }}" required>
                            </div>

                            <div>
                                <label class="block mb-1 text-xs font-medium text-slate-800">Unit</label>
                                <input type="number" min="0" name="unit" value="{{ $item['unit'] ?? 0 }}" class="{{ $inputClass }}" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-1 text-xs font-medium text-slate-800">Keterangan</label>
                                <textarea name="deskripsi" rows="3" class="{{ $inputClass }}" required>{{ $item['deskripsi'] ?? '' }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-1 text-xs font-medium text-slate-800">Link Gambar</label>
                                <input type="text" name="gambar" value="{{ $item['gambar'] ?? '' }}" class="{{ $inputClass }}">
                            </div>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button
                                type="button"
                                data-modal-hide="editBarangModal{{ $item['id'] }}"
                                class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-xl hover:bg-slate-200 transition-all duration-300"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md"
                            >
                                Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

</div>
@endsection