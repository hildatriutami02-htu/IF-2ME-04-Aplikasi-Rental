@extends('admin.dashboard-admin')

@section('title', 'Dashboard Admin - LensCamp')
@section('page_title', 'Dashboard')
@section('page_desc', 'Panel kontrol admin LensCamp')

@section('content')

@php
    $stats = [
        ['title' => 'Pendapatan', 'value' => 'Rp 12.500.000', 'desc' => 'Bulan ini', 'sub' => 'Data keuangan terkini'],
        ['title' => 'Total Rental', 'value' => '48 Transaksi', 'desc' => 'Aktif', 'sub' => 'Rental berjalan & selesai'],
        ['title' => 'Total User', 'value' => '126 User', 'desc' => 'Terdaftar', 'sub' => 'Akun pengguna aktif'],
        ['title' => 'Produk', 'value' => '32 Barang', 'desc' => 'Siap sewa', 'sub' => 'Stok tercatat sistem'],
    ];

    $menus = [
        ['route' => 'admin.users.index', 'label' => 'Kelola Tabel User'],
        ['route' => 'admin.products', 'label' => 'Kelola Katalog Barang'],
        ['route' => 'admin.rentals', 'label' => 'Kelola Data Sewa'],
        ['route' => 'admin.reports', 'label' => 'Lihat Laporan'],
    ];
@endphp

<div class="max-w-6xl mx-auto space-y-5">

    <!-- ================= STATISTIK ================= -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        @foreach ($stats as $i => $item)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 animate-fade-up{{ $i ? '-delay-'.$i : '' }}">
            <div class="flex justify-between">
                <div>
                    <p class="text-sm text-slate-500">{{ $item['title'] }}</p>
                    <h3 class="text-2xl font-bold mt-2">{{ $item['value'] }}</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-700"></div>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <span class="px-2.5 py-1 text-[11px] font-medium bg-blue-50 text-blue-700 rounded-full">
                    {{ $item['desc'] }}
                </span>
                <span class="text-xs text-slate-400">{{ $item['sub'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <!-- ================= MENU CEPAT ================= -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                <h3 class="text-xl font-bold">Menu Cepat</h3>
            </div>

            <div class="space-y-4">
                @foreach ($menus as $menu)
                <a href="{{ route($menu['route']) }}"
                   class="group flex justify-between px-5 py-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold hover:bg-blue-100 hover:-translate-y-0.5 transition">
                    <span>{{ $menu['label'] }}</span>
                    <span class="group-hover:translate-x-1 transition">→</span>
                </a>
                @endforeach
            </div>
        </div>

        <!-- ================= RINGKASAN ================= -->
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-8 bg-blue-600 rounded-full"></div>
                <h3 class="text-xl font-bold">Ringkasan Aktivitas</h3>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                @foreach ([
                    ['Booking','12','Hari ini'],
                    ['Sedang Disewa','19','Aktif'],
                    ['Sudah Dikembalikan','8','Selesai'],
                    ['User Aktif','74','Online']
                ] as $item)

                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 hover:-translate-y-1 transition">
                    <div class="flex justify-between">
                        <p class="text-sm text-slate-500">{{ $item[0] }}</p>
                        <span class="text-[11px] bg-white text-blue-700 border px-2 py-1 rounded-full">
                            {{ $item[2] }}
                        </span>
                    </div>
                    <h4 class="text-2xl font-bold mt-3">{{ $item[1] }}</h4>
                </div>

                @endforeach
            </div>
        </div>
    </div>

    <!-- ================= USER TERBARU ================= -->
    <div class="grid xl:grid-cols-2 gap-5">

        <div class="bg-white rounded-2xl border p-5">
            <h3 class="text-xl font-bold mb-4">User Terbaru</h3>

            @foreach ([
                ['A','USR001 - Ahmad','Terdaftar hari ini','Aktif'],
                ['P','USR002 - Putri','Terdaftar kemarin','Aktif'],
                ['B','USR003 - Budi','2 hari lalu','Baru']
            ] as $user)

            <div class="flex justify-between px-3 py-3 hover:bg-slate-50 rounded-xl">
                <div class="flex gap-3">
                    <div class="w-11 h-11 bg-blue-50 flex items-center justify-center rounded-full font-bold">
                        {{ $user[0] }}
                    </div>
                    <div>
                        <p class="font-semibold">{{ $user[1] }}</p>
                        <p class="text-sm text-slate-500">{{ $user[2] }}</p>
                    </div>
                </div>
                <span class="text-xs px-3 py-1 rounded-full bg-blue-50">
                    {{ $user[3] }}
                </span>
            </div>

            @endforeach
        </div>

        <!-- ================= RENTAL ================= -->
        <div class="bg-white rounded-2xl border p-5">
            <h3 class="text-xl font-bold mb-4">Riwayat Rental</h3>

            @foreach ([
                ['Canon','Ahmad'],
                ['Tenda','Putri'],
                ['Tripod','Budi']
            ] as $rental)

            <div class="px-3 py-3 hover:bg-slate-50 rounded-xl">
                <p class="font-semibold">{{ $rental[0] }}</p>
                <p class="text-sm text-slate-500">{{ $rental[1] }}</p>
            </div>

            @endforeach
        </div>
    </div>

</div>
@endsection