@extends('admin.dashboard-admin')

@section('title', 'Dashboard Admin - LensCamp')
@section('page_title', 'Dashboard')
@section('page_desc', 'Panel kontrol admin LensCamp')

@section('content')

@php
    $stats = [
        [
            'title' => 'Pendapatan',
            'value' => 'Rp ' . number_format($totalPendapatan ?? 0, 0, ',', '.'),
            'desc' => 'Bulan ini',
            'sub' => 'Data keuangan terkini',
        ],
        [
            'title' => 'Total Rental',
            'value' => ($totalRental ?? 0) . ' Transaksi',
            'desc' => 'Aktif',
            'sub' => 'Rental berjalan & selesai',
        ],
        [
            'title' => 'Total User',
            'value' => ($totalUser ?? 0) . ' User',
            'desc' => 'Terdaftar',
            'sub' => 'Akun pengguna aktif',
        ],
        [
            'title' => 'Produk',
            'value' => ($totalProduk ?? 0) . ' Barang',
            'desc' => 'Siap sewa',
            'sub' => 'Stok tercatat sistem',
        ],
    ];

    $menus = [
        ['route' => 'admin.users.index', 'label' => 'Kelola Tabel User'],
        ['route' => 'admin.products', 'label' => 'Kelola Katalog Barang'],
        ['route' => 'admin.rentals', 'label' => 'Kelola Data Sewa'],
        ['route' => 'admin.reports', 'label' => 'Lihat Laporan'],
    ];
@endphp

<div class="max-w-6xl mx-auto space-y-5">

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        @foreach ($stats as $i => $item)
        <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-[#437057] animate-fade-up{{ $i ? '-delay-'.$i : '' }}">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-slate-500">{{ $item['title'] }}</p>
                    <h3 class="text-2xl font-bold mt-2 text-slate-800">{{ $item['value'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#eef3ee] border border-[#dfe7df] flex items-center justify-center text-[#2F5249]">
                </div>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <span class="px-2.5 py-1 text-[11px] font-medium bg-[#eef3ee] text-[#2F5249] rounded-full">
                    {{ $item['desc'] }}
                </span>
                <span class="text-xs text-slate-400">{{ $item['sub'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-8 bg-[#2F5249] rounded-full"></div>
                <h3 class="text-xl font-bold text-[#2F5249]">Menu Cepat</h3>
            </div>

            <div class="space-y-4">
                @foreach ($menus as $menu)
                <a href="{{ route($menu['route']) }}"
                   class="group flex justify-between px-5 py-4 rounded-xl bg-[#eef3ee] border border-[#dfe7df] text-[#2F5249] font-semibold hover:bg-[#dfe7df] hover:-translate-y-0.5 transition">
                    <span>{{ $menu['label'] }}</span>
                    <span class="group-hover:translate-x-1 transition">→</span>
                </a>
                @endforeach
            </div>
        </div>

        <div class="xl:col-span-2 bg-white rounded-2xl border border-[#dfe7df] shadow-sm p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-8 bg-[#2F5249] rounded-full"></div>
                <h3 class="text-xl font-bold text-[#2F5249]">Ringkasan Aktivitas</h3>
            </div>

            @foreach ([
                ['Menunggu Verifikasi', $totalMenungguVerifikasi, 'Perlu Dicek'],
                ['Sedang Disewa', $totalSedangDisewa, 'Aktif'],
                ['Sudah Dikembalikan', $totalDikembalikan, 'Selesai'],
                ['User Aktif', $totalUserAktif, 'Online']
            ] as $item)

                <div class="rounded-2xl bg-[#F8FAF7] border border-[#dfe7df] p-5 hover:-translate-y-1 transition mb-3">
                    <div class="flex justify-between">
                        <p class="text-sm text-slate-500">{{ $item[0] }}</p>
                        <span class="text-[11px] bg-white text-[#2F5249] border border-[#dfe7df] px-2 py-1 rounded-full">
                            {{ $item[2] }}
                        </span>
                    </div>
                    <h4 class="text-2xl font-bold mt-3 text-slate-800">{{ $item[1] }}</h4>
                </div>

            @endforeach
        </div>
    </div>

    <div class="grid xl:grid-cols-2 gap-5">

        <div class="bg-white rounded-2xl border border-[#dfe7df] p-5">
            <h3 class="text-xl font-bold mb-4 text-[#2F5249]">User Terbaru</h3>

            @foreach ($latestUsers as $user)
            <div class="flex justify-between px-3 py-3 hover:bg-[#F8FAF7] rounded-xl">
                <div class="flex gap-3">
                    <div class="w-11 h-11 bg-[#eef3ee] text-[#2F5249] flex items-center justify-center rounded-full font-bold">
                        {{ substr($user['nama'], 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold">{{ $user['kode'] }} - {{ $user['nama'] }}</p>
                        <p class="text-sm text-slate-500">{{ $user['waktu'] }}</p>
                    </div>
                </div>
                <span class="text-xs px-3 py-1 rounded-full bg-[#eef3ee] text-[#2F5249]">
                    {{ $user['status'] }}
                </span>
            </div>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl border border-[#dfe7df] p-5">
            <h3 class="text-xl font-bold mb-4 text-[#2F5249]">Riwayat Rental</h3>

            @foreach ($latestRentals as $rental)
            <div class="px-3 py-3 hover:bg-[#F8FAF7] rounded-xl">
                <p class="font-semibold">{{ $rental['produk'] }}</p>
                <p class="text-sm text-slate-500">{{ $rental['pelanggan'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection