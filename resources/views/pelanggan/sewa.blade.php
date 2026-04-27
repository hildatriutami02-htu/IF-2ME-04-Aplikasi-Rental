@extends('pelanggan.layouts.app')

@php
    $title = 'Sewa Saya - LensCamp';
    $headerTitle = 'Sewa Saya';
    $headerDesc = 'Pantau semua status penyewaan yang sedang berjalan';

    $rentals = $rentals ?? [
        [
            'id' => 1,
            'invoice' => 'TRX001',
            'produk' => 'Tenda 4 Orang',
            'tanggal_pinjam' => '12 Apr 2026',
            'tanggal_kembali' => '14 Apr 2026',
            'tanggal_kembali_real' => null,
            'qty' => 1,
            'harga' => 200000,
            'denda' => 0,
            'status' => 'Booking',
            'status_pembayaran' => 'Belum Bayar',
            'warna' => 'blue',
        ],
        [
            'id' => 2,
            'invoice' => 'TRX002',
            'produk' => 'Tripod Kamera',
            'tanggal_pinjam' => '15 Apr 2026',
            'tanggal_kembali' => '16 Apr 2026',
            'tanggal_kembali_real' => '16 Apr 2026',
            'qty' => 1,
            'harga' => 55000,
            'denda' => 0,
            'status' => 'Dikembalikan',
            'status_pembayaran' => 'Lunas',
            'warna' => 'slate',
        ],
    ];

    $summaryCards = [
        [
            'label' => 'Total Transaksi',
            'value' => count($rentals),
            'class' => 'text-slate-800',
        ],
        [
            'label' => 'Sedang Booking',
            'value' => collect($rentals)->where('status', 'Booking')->count(),
            'class' => 'text-blue-600',
        ],
        [
            'label' => 'Total Pengeluaran',
            'value' => 'Rp ' . number_format(collect($rentals)->sum('harga'), 0, ',', '.'),
            'class' => 'text-slate-800',
        ],
    ];
@endphp

@section('content')
<div class="space-y-6">

    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- SUMMARY -->
    <section class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach($summaryCards as $card)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">{{ $card['label'] }}</p>
                <h3 class="mt-2 text-3xl font-bold {{ $card['class'] }}">
                    {{ $card['value'] }}
                </h3>
            </div>
        @endforeach
    </section>

    <!-- LIST -->
    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-5 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Daftar Penyewaan</h3>
                <p class="text-sm text-slate-500 mt-1">Semua transaksi sewa yang pernah kamu buat akan muncul di sini.</p>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($rentals as $item)
                @php
                    $statusClass = ($item['warna'] ?? '') === 'blue'
                        ? 'bg-blue-50 text-blue-700'
                        : 'bg-slate-100 text-slate-700';

                    $payClass = match($item['status_pembayaran'] ?? '') {
                        'DP' => 'bg-yellow-50 text-yellow-700',
                        'Lunas' => 'bg-green-50 text-green-700',
                        default => 'bg-red-50 text-red-700',
                    };

                    $isBooking = ($item['status'] ?? '') === 'Booking';
                    $denda = (int) ($item['denda'] ?? 0);
                @endphp

                <div class="rounded-2xl border border-slate-200 p-5 hover:shadow-sm transition">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-semibold tracking-wide text-slate-400 uppercase">
                                    {{ $item['invoice'] ?? '-' }}
                                </p>
                                <h4 class="text-lg font-bold text-slate-800">
                                    {{ $item['produk'] ?? '-' }}
                                </h4>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-slate-500 text-xs mb-1">Periode Sewa</p>
                                    <p class="font-medium text-slate-800">
                                        {{ $item['tanggal_pinjam'] ?? '-' }} - {{ $item['tanggal_kembali'] ?? '-' }}
                                    </p>
                                    @if(!empty($item['tanggal_kembali_real']))
                                        <p class="text-xs text-green-600 mt-1">
                                            Dikembalikan: {{ $item['tanggal_kembali_real'] }}
                                        </p>
                                    @endif
                                </div>

                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-slate-500 text-xs mb-1">Jumlah Unit</p>
                                    <p class="font-medium text-slate-800">
                                        {{ $item['qty'] ?? 1 }} unit
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-slate-500 text-xs mb-1">Biaya Sewa</p>
                                    <p class="font-semibold text-blue-600">
                                        Rp {{ number_format((int) ($item['harga'] ?? 0), 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-slate-50 px-4 py-3">
                                    <p class="text-slate-500 text-xs mb-1">Denda</p>
                                    <p class="font-semibold {{ $denda > 0 ? 'text-red-600' : 'text-slate-800' }}">
                                        Rp {{ number_format($denda, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-start lg:items-end gap-3 min-w-[180px]">
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ $item['status'] ?? '-' }}
                                </span>

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $payClass }}">
                                    {{ $item['status_pembayaran'] ?? '-' }}
                                </span>
                            </div>

                            @if($isBooking && !empty($item['id']))
                                <a href="{{ route('pelanggan.sewa.extend', $item['id']) }}"
                                   class="inline-flex items-center rounded-2xl bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 transition">
                                    Perpanjang Sewa
                                </a>
                            @endif
                        </div>

                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 p-10 text-center">
                    <p class="text-slate-500">Belum ada transaksi sewa.</p>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection