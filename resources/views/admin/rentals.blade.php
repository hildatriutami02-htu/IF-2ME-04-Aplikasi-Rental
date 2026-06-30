@extends('admin.dashboard-admin')

@section('title', 'Data Sewa - LensCamp')
@section('page_title', 'Data Sewa')
@section('page_desc', 'Kelola transaksi penyewaan')

@section('content')

@php
    $inputClass = 'bg-[#F8FAF7] border border-[#dfe7df] text-sm rounded-xl block w-full p-2.5 focus:ring-4 focus:ring-[#DDE8DF] focus:border-[#2F5249] transition-all duration-200';
    $btnPrimary = 'px-4 py-2 rounded-xl bg-[#2F5249] hover:bg-[#437057] text-white font-medium text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md';
    $btnSecondary = 'px-4 py-2 rounded-xl bg-[#eef3ee] hover:bg-[#dfe7df] text-[#2F5249] font-medium text-sm transition-all duration-300 hover:-translate-y-0.5';

    $selectedStatus = request('status', 'semua');
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

    <div class="bg-white rounded-2xl shadow-sm border border-[#dfe7df] overflow-hidden hover:shadow-md transition">
        <div class="px-4 py-3 border-b border-[#dfe7df]">
            <h3 class="text-sm font-bold text-[#2F5249]">Input Transaksi Sewa</h3>
        </div>

        <form action="{{ route('admin.rentals.store') }}" method="POST" class="p-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Pelanggan</label>
                    <select name="user_id" class="{{ $inputClass }}" required>
                        <option value="">Pilih Pelanggan</option>
                        @foreach($users as $user)
                            <option value="{{ $user['id'] }}">
                                {{ $user['nama_lengkap'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Barang</label>
                    <select name="product_id" class="{{ $inputClass }}" required>
                        <option value="">Pilih Barang</option>
                        @foreach($products as $product)
                            <option value="{{ $product['id'] }}">
                                {{ $product['nama_barang'] ?? '-' }} - Rp {{ number_format((int) ($product['harga'] ?? 0), 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Qty</label>
                    <input type="number" min="1" name="qty" value="1" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Status Pembayaran</label>
                    <select name="status_pembayaran" class="{{ $inputClass }}" required>
                        <option value="Belum Bayar">Belum Bayar</option>
                        <option value="DP">DP</option>
                        <option value="Lunas">Lunas</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Status Transaksi</label>
                    <select name="status_transaksi" class="{{ $inputClass }}" required>
                        <option value="Booking">Booking</option>
                        <option value="Dikembalikan">Dikembalikan</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-xs font-medium text-slate-800">Catatan</label>
                    <input type="text" name="catatan" class="{{ $inputClass }}" placeholder="Catatan tambahan">
                </div>

            </div>

            <div class="flex gap-2 pt-3">
                <button type="submit" class="{{ $btnPrimary }}">Simpan</button>
                <button type="reset" class="{{ $btnSecondary }}">Reset</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-[#dfe7df] overflow-hidden hover:shadow-md transition">

        <div class="px-4 py-3 border-b border-[#dfe7df] flex flex-wrap gap-2">
            @foreach([
            ['label'=>'Booking','value'=>'Booking'],
            ['label'=>'Permintaan Perpanjangan','value'=>'Permintaan Perpanjangan'],
            ['label'=>'Sedang Disewa','value'=>'Sedang Disewa'],
            ['label'=>'Dikembalikan','value'=>'Dikembalikan'],
            ['label'=>'Semua','value'=>'semua'],
        ] as $filter)

                <a href="{{ route('admin.rentals', $filter['value'] === 'semua' ? [] : ['status' => $filter['value']]) }}"
                   class="px-4 h-9 inline-flex items-center text-sm rounded-xl transition-all duration-200
                   {{ $selectedStatus === $filter['value'] ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249] hover:bg-[#dfe7df]' }}">
                   {{ $filter['label'] }}

                    <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] bg-white/20">
                        {{
                            $filter['value'] === 'semua'
                                ? ($statusCounts['Semua'] ?? 0)
                                : ($statusCounts[$filter['value']] ?? 0)
                        }}
                    </span>
                </a>

            @endforeach
        </div>

        <div class="overflow-x-auto custom-scroll pb-24">
            <table class="w-full text-xs text-left text-slate-600">
                <thead class="text-xs text-[#2F5249] uppercase bg-[#F8FAF7] border-b border-[#dfe7df]">
                    <tr>
                        <th class="px-2 py-3">Kode</th>
                        <th class="px-2 py-3">Pelanggan</th>
                        <th class="px-2 py-3">No WA</th>
                        <th class="px-2 py-3">Barang</th>
                        <th class="px-2 py-3 text-center">Qty</th>
                        <th class="px-2 py-3">Periode</th>
                        <th class="px-2 py-3">Biaya</th>
                        <th class="px-2 py-3">Bayar</th>
                        <th class="px-2 py-3">Bukti</th>
                        <th class="px-2 py-3">Status</th>
                        <th class="px-2 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rentals as $item)

                        @php
                            $status = $item['status_transaksi'] ?? 'Booking';

                            $badgeClass = match($status) {
                            'Dikembalikan' => 'bg-[#DDE8DF] text-[#437057]',
                            'Sedang Disewa' => 'bg-[#DDE8DF] text-[#2F5249]',
                            'Diperpanjang' => 'bg-blue-100 text-blue-700',
                            'Permintaan Perpanjangan' => 'bg-purple-100 text-purple-700',
                            default => 'bg-amber-100 text-amber-700',
                        };

                            $payClass = match($item['status_pembayaran'] ?? '') {
                                'DP' => 'bg-amber-100 text-amber-700',
                                'Lunas' => 'bg-[#DDE8DF] text-[#437057]',
                                default => 'bg-red-100 text-red-700'
                            };

                            $totalDenda = (int) ($item['total_denda'] ?? 0);
                        @endphp

                        <tr class="bg-white border-b border-[#dfe7df] hover:bg-[#F8FAF7] transition align-top">
                            <td class="px-2 py-3 font-semibold text-slate-800 whitespace-nowrap">
                                {{ $item['kode_transaksi'] ?? '-' }}
                            </td>

                            <td class="px-2 py-3 whitespace-nowrap">
                                {{ $item['nama_pelanggan'] ?? '-' }}
                            </td>

                            <td class="px-2 py-3 whitespace-nowrap">
                                {{ $item['no_wa'] ?? '-' }}
                            </td>

                            <td class="px-2 py-3">
                                <div class="font-medium text-slate-700">
                                    {{ $item['nama_barang'] ?? '-' }}
                                </div>
                            </td>

                            <td class="px-2 py-3 text-center">
                                {{ $item['qty'] ?? 1 }}
                            </td>

                           <td class="px-2 py-3 whitespace-nowrap">
                            <td class="px-2 py-3 whitespace-nowrap">
                                @php
                                    $dendaPerHari = 25000;

                                    $tanggalPinjam = $item['tanggal_pinjam_raw'] ?? $item['tanggal_pinjam'] ?? null;
                                    $tanggalKembali = $item['tanggal_kembali_raw'] ?? $item['tanggal_kembali'] ?? null;

                                    $isTelat = false;
                                    $hariTelat = 0;
                                    $totalDendaTelat = 0;

                                    if ($tanggalKembali && ($item['status_transaksi'] ?? '') == 'Sedang Disewa') {
                                        $batas = \Carbon\Carbon::parse($tanggalKembali)->startOfDay();
                                        $hariIni = now()->startOfDay();

                                        if ($hariIni->gt($batas)) {
                                            $isTelat = true;
                                            $hariTelat = $batas->diffInDays($hariIni);
                                            $totalDendaTelat = $hariTelat * $dendaPerHari;
                                        }
                                    }
                                @endphp

                                @if($tanggalPinjam && $tanggalKembali)
                                    <div>
                                        {{ \Carbon\Carbon::parse($tanggalPinjam)->format('d/m') }}
                                        -
                                        {{ \Carbon\Carbon::parse($tanggalKembali)->format('d/m') }}
                                    </div>

                                    @if($isTelat)
                                        <div class="mt-1 text-[10px] text-red-600 font-semibold">
                                            🔴 Terlambat {{ $hariTelat }} Hari
                                        </div>

                                        <div class="text-[10px] text-red-600">
                                            Denda: <b>Rp {{ number_format($totalDendaTelat, 0, ',', '.') }}</b>
                                        </div>
                                    @endif
                                @else
                                    <div>-</div>
                                @endif
                            </td>

                            <td class="px-2 py-3 whitespace-nowrap">
                                <div class="font-semibold text-[#2F5249]">
                                    Rp {{ number_format((int) ($item['total_harga'] ?? 0), 0, ',', '.') }}
                                </div>

                                @if($totalDenda > 0)
                                    <div class="text-[10px] text-red-600 mt-0.5">
                                        Denda: Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                    </div>
                                @endif
                            </td>
                                <td class="px-2 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $payClass }}">
                                        {{ $item['status_pembayaran'] ?? '-' }}
                                    </span>
                                </td>

                                <td class="px-2 py-3">
                                    @if(!empty($item['bukti_bayar']))
                                        <button
                                            type="button"
                                            data-image="{{ asset('storage/' . $item['bukti_bayar']) }}"
                                            onclick="openImage(this)"
                                            class="px-3 py-1 rounded-full bg-[#eef3ee] text-[#2F5249] text-[10px] font-semibold hover:bg-[#dfe7df]">
                                            Lihat Bukti
                                        </button>
                                    @else
                                        <span class="text-[10px] text-slate-400">
                                            Belum Upload
                                        </span>
                                    @endif
                                </td>

                                <td class="px-2 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $badgeClass }}">
                                        {{ $status }}
                                    </span>
                                </td>

                            <td class="px-2 py-3 text-center">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button
                                        type="button"
                                        @click="open = !open"
                                        class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-[#eef3ee] hover:bg-[#dfe7df] text-[#2F5249] border border-[#dfe7df] transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 6a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm0 5a1.5 1.5 0 110-3 1.5 1.5 0 010 3z" />
                                        </svg>
                                    </button>

                                    <div
                                        x-show="open"
                                        @click.away="open = false"
                                        x-transition
                                        class="absolute right-0 z-50 mt-2 w-44 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black/5 border border-[#dfe7df] overflow-hidden"
                                        style="display: none;"
                                    >
                                        <a href="{{ route('admin.rentals.show', $item['id']) }}"
                                           class="block px-4 py-2.5 text-sm text-slate-700 hover:bg-[#F8FAF7]">
                                            Detail
                                        </a>

                                        @if(in_array(($item['status_transaksi'] ?? ''), ['Booking', 'Menunggu Verifikasi', 'Permintaan Perpanjangan']))
                                        <form action="{{ route('admin.rentals.verify', $item['id']) }}"
                                            method="POST"
                                            onsubmit="return confirm('Verifikasi transaksi ini?')">
                                            @csrf
                                            <input type="hidden" name="status_filter" value="{{ request('status', 'semua') }}">

                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2.5 text-sm text-[#2F5249] hover:bg-[#eef3ee]">
                                                Verifikasi
                                            </button>
                                        </form>
                                    @endif

                                        @if(($item['status_transaksi'] ?? '') === 'Sedang Disewa')
                                            <a href="{{ route('admin.rentals.extend', $item['id']) }}"
                                               class="block px-4 py-2.5 text-sm text-amber-600 hover:bg-amber-50">
                                                Perpanjang
                                            </a>

                                            <form action="{{ route('admin.rentals.return', $item['id']) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Tandai transaksi ini sudah dikembalikan?')">
                                                @csrf
                                                <input type="hidden" name="status_filter" value="{{ request('status', 'semua') }}">
                                                <button type="submit"
                                                    class="block w-full text-left px-4 py-2.5 text-sm text-[#437057] hover:bg-[#eef3ee]">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.rentals.destroy', $item['id']) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="status_filter" value="{{ request('status', 'semua') }}">
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="11" class="px-4 py-6 text-center text-slate-500">
                                Belum ada transaksi sewa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</div>

<div id="imageModal"
     class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50"
     onclick="closeImage(event)">

    <img id="previewImage"
         class="max-w-[90%] max-h-[90%] rounded-lg shadow-xl">
</div>

<script>
function openImage(button){
    document.getElementById('previewImage').src = button.dataset.image;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}

function closeImage(e){
    if(e.target.id === 'imageModal'){
        document.getElementById('imageModal').classList.remove('flex');
        document.getElementById('imageModal').classList.add('hidden');
    }
}
</script>
@endsection