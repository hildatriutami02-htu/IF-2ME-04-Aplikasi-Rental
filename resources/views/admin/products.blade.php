@extends('admin.dashboard-admin')

@section('title', 'Katalog Barang - LensCamp')
@section('page_title', 'Katalog Barang')
@section('page_desc', 'Kelola produk rental')

@section('content')
@php
    $totalBarang = count($products);
    $totalUnit = collect($products)->sum('unit');
    $totalReady = collect($products)->where('status', 'Ready')->count();

    $inputClass = 'bg-[#F8FAF7] border border-[#dfe7df] text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-[#DDE8DF] focus:border-[#2F5249] transition-all duration-200';
    $cardClass = 'bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-3 flex items-center gap-3 hover:bg-[#F8FAF7] hover:-translate-y-0.5 hover:shadow-md transition-all duration-300';
$summaryCards = [
    [
        'href' => null,
        'icon' => 'package',
        'iconClass' => 'bg-[#2F5249] text-white',
        'label' => 'Total Barang',
        'value' => $totalBarang,
        'clickable' => false,
    ],
    [
        'href' => null,
        'icon' => 'layers',
        'iconClass' => 'bg-[#DDE8DF] text-[#2F5249]',
        'label' => 'Total Unit',
        'value' => $totalUnit,
        'clickable' => false,
    ],
    [
        'href' => null,
        'icon' => 'check-circle',
        'iconClass' => 'bg-[#437057] text-white',
        'label' => 'Barang Ready',
        'value' => $totalReady,
        'clickable' => false,
    ],
];
@endphp

<div class="max-w-7xl mx-auto space-y-4 animate-fade-up">

    @if(session('success'))
        <div class="rounded-2xl border border-[#dfe7df] bg-[#eef3ee] text-[#2F5249] px-4 py-3 text-sm shadow-sm">
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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
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
                <div class="{{ $cardClass }}">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl {{ $card['iconClass'] }}">
                        <i data-feather="{{ $card['icon'] }}" class="w-5 h-5"></i>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500">{{ $card['label'] }}</p>
                        <h3 class="text-xl font-bold text-slate-800">{{ $card['value'] }}</h3>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#dfe7df] overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-4 py-3 border-b border-[#dfe7df]">
            <h3 class="text-base font-bold text-[#2F5249]">Input Data Barang</h3>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
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
                            <input type="file" name="gambar" accept="image/*" class="{{ $inputClass }}">
                        </div>
                    </div>

                    <div class="flex gap-2 pt-1">
                        <button type="submit"
                            class="px-4 py-2 rounded-xl bg-[#2F5249] text-white text-sm font-semibold hover:bg-[#437057] transition">
                            Simpan
                        </button>

                        <button type="button"
                            class="px-4 py-2 rounded-xl bg-[#eef3ee] text-[#2F5249] text-sm font-semibold hover:bg-[#dfe7df] transition">
                            Batalkan
                        </button>
                    </div>
                </div>

                <div class="xl:col-span-1">
                    <div class="border border-[#dfe7df] rounded-2xl p-3 bg-[#F8FAF7] min-h-[180px] flex items-center justify-center shadow-sm">
                        <img id="previewImage" class="w-24 h-24 object-cover rounded-xl border border-[#dfe7df] hidden" />

                        <div id="previewText" class="text-xs text-slate-400 text-center">
                            Preview Gambar
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#dfe7df] overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="px-4 py-3 border-b border-[#dfe7df] flex items-center justify-between">
            <h3 class="text-base font-bold text-[#2F5249]">Katalog Barang</h3>
            <span class="text-xs text-slate-500">Data barang rental</span>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full min-w-[1100px] text-sm text-left text-slate-600">
                <thead class="text-xs text-[#2F5249] bg-[#F8FAF7] border-b border-[#dfe7df] uppercase">
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
                            $badgeClass = 'bg-[#DDE8DF] text-[#437057]';

                            if (strtolower($status) === 'pending') {
                                $badgeClass = 'bg-amber-100 text-amber-700';
                            } elseif (strtolower($status) === 'disewa') {
                                $badgeClass = 'bg-[#DDE8DF] text-[#2F5249]';
                            }
                        @endphp

                        <tr class="bg-white border-b border-[#dfe7df] hover:bg-[#F8FAF7] transition-colors duration-200">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                            <td class="px-4 py-3">{{ $item['kode_barang'] ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">{{ $item['nama_barang'] ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item['jenis_barang'] ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium {{ $badgeClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#2F5249] font-semibold">
                                Rp. {{ number_format((int) ($item['harga'] ?? 0), 0, ',', '.') }} /Hari
                            </td>
                            <td class="px-4 py-3">{{ $item['unit'] ?? 0 }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center gap-2 whitespace-nowrap">

                                    <a href="{{ route('admin.products.show', $item['id']) }}"
                                       class="px-3 py-2 bg-[#2F5249] hover:bg-[#437057] text-white rounded-xl text-xs font-semibold transition">
                                        Detail
                                    </a>

                                    <a href="{{ route('admin.products.edit', $item['id']) }}"
                                       class="px-3 py-2 bg-[#eef3ee] hover:bg-[#dfe7df] text-[#2F5249] rounded-xl text-xs font-semibold transition">
                                        Update
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl text-xs font-semibold transition">
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

        <div class="px-4 py-3 border-t border-[#dfe7df] flex items-center justify-between">
            <span class="text-xs text-slate-500">
                Menampilkan {{ count($products) > 0 ? '1-' . count($products) : '0' }} dari {{ count($products) }} data
            </span>
            <span class="text-xs text-slate-500">Halaman 1</span>
        </div>
    </div>

</div>

<script>
document.querySelector('input[name="gambar"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('previewImage');
    const text = document.getElementById('previewText');

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            text.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection