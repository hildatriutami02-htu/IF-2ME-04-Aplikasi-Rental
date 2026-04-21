@extends('admin.dashboard-admin')

@section('title', 'Dashboard Admin - LensCamp')
@section('page_title', 'Dashboard')
@section('page_desc', 'Panel kontrol admin LensCamp')

@section('content')
<div class="max-w-6xl mx-auto space-y-5">

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 animate-fade-up">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Pendapatan</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-2">Rp 12.500.000</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10v12m9-6a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Bulan ini</span>
                <span class="text-xs text-slate-400">Data keuangan terkini</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 animate-fade-up-delay-1">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Rental</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-2">48 Transaksi</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Aktif</span>
                <span class="text-xs text-slate-400">Rental berjalan & selesai</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 animate-fade-up-delay-2">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total User</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-2">126 User</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V10a2 2 0 00-2-2h-3m-4 12H4a2 2 0 01-2-2v-3m18-7V6a2 2 0 00-2-2h-3M9 20H7a2 2 0 01-2-2v-2m11-7a4 4 0 11-8 0 4 4 0 018 0zm-1 11a5 5 0 00-10 0"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Terdaftar</span>
                <span class="text-xs text-slate-400">Akun pengguna aktif</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:border-slate-300 animate-fade-up-delay-3">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-slate-500">Produk</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-2">32 Barang</h3>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 00-1-1.732l-6-3.429a2 2 0 00-2 0l-6 3.429A2 2 0 004 7v6a2 2 0 001 1.732l6 3.429a2 2 0 002 0l6-3.429A2 2 0 0020 13z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-blue-50 text-blue-700">Siap sewa</span>
                <span class="text-xs text-slate-400">Stok tercatat sistem</span>
            </div>
        </div>
    </div>

    <!-- Menu cepat + ringkasan -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-8 rounded-full bg-blue-600"></div>
                <h3 class="text-xl font-bold text-slate-800">Menu Cepat</h3>
            </div>

            <div class="space-y-4">
                <a href="{{ route('admin.users') }}" class="group flex items-center justify-between px-5 py-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold transition-all duration-300 hover:bg-blue-100 hover:shadow-sm hover:-translate-y-0.5">
                    <span>Kelola Tabel User</span>
                    <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                </a>

                <a href="{{ route('admin.products') }}" class="group flex items-center justify-between px-5 py-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold transition-all duration-300 hover:bg-blue-100 hover:shadow-sm hover:-translate-y-0.5">
                    <span>Kelola Katalog Barang</span>
                    <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                </a>

                <a href="{{ route('admin.rentals') }}" class="group flex items-center justify-between px-5 py-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold transition-all duration-300 hover:bg-blue-100 hover:shadow-sm hover:-translate-y-0.5">
                    <span>Kelola Data Sewa</span>
                    <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                </a>

                <a href="{{ route('admin.reports') }}" class="group flex items-center justify-between px-5 py-4 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold transition-all duration-300 hover:bg-blue-100 hover:shadow-sm hover:-translate-y-0.5">
                    <span>Lihat Laporan</span>
                    <span class="transition-transform duration-300 group-hover:translate-x-1">→</span>
                </a>
            </div>
        </div>

        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-1.5 h-8 rounded-full bg-blue-600"></div>
                <h3 class="text-xl font-bold text-slate-800">Ringkasan Aktivitas</h3>
            </div>

            <div class="grid md:grid-cols-2 gap-5">
                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Booking</p>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-white text-blue-700 border border-blue-100">Hari ini</span>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mt-3">12</h4>
                </div>

                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Sedang Disewa</p>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-white text-blue-700 border border-blue-100">Aktif</span>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mt-3">19</h4>
                </div>

                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">Sudah Dikembalikan</p>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-white text-blue-700 border border-blue-100">Selesai</span>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mt-3">8</h4>
                </div>

                <div class="rounded-2xl bg-blue-50 border border-blue-100 p-5 transition-all duration-300 hover:-translate-y-1 hover:shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-slate-500">User Aktif</p>
                        <span class="px-2.5 py-1 rounded-full text-[11px] font-medium bg-white text-blue-700 border border-blue-100">Online</span>
                    </div>
                    <h4 class="text-2xl font-bold text-slate-800 mt-3">74</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- User terbaru + rental terbaru -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-8 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-slate-800">User Terbaru</h3>
                </div>
                <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline transition-colors duration-200">
                    Lihat semua
                </a>
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between border border-transparent hover:border-slate-200 hover:bg-slate-50 rounded-xl px-3 py-3 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-blue-50 border border-blue-100 text-blue-700 font-bold flex items-center justify-center">A</div>
                        <div>
                            <p class="font-semibold text-slate-800">USR001 - Ahmad Nasrulloh</p>
                            <p class="text-sm text-slate-500">Terdaftar hari ini</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Aktif</span>
                </div>

                <div class="flex items-center justify-between border border-transparent hover:border-slate-200 hover:bg-slate-50 rounded-xl px-3 py-3 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-blue-50 border border-blue-100 text-blue-700 font-bold flex items-center justify-center">P</div>
                        <div>
                            <p class="font-semibold text-slate-800">USR002 - Putri Audry</p>
                            <p class="text-sm text-slate-500">Terdaftar kemarin</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Aktif</span>
                </div>

                <div class="flex items-center justify-between border border-transparent hover:border-slate-200 hover:bg-slate-50 rounded-xl px-3 py-3 transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-slate-100 border border-slate-200 text-slate-700 font-bold flex items-center justify-center">B</div>
                        <div>
                            <p class="font-semibold text-slate-800">USR003 - Budi Santoso</p>
                            <p class="text-sm text-slate-500">Terdaftar 2 hari lalu</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Baru</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-8 rounded-full bg-blue-600"></div>
                    <h3 class="text-xl font-bold text-slate-800">Riwayat Rental Terbaru</h3>
                </div>
                <a href="{{ route('admin.rentals') }}" class="text-sm text-blue-600 hover:text-blue-700 hover:underline transition-colors duration-200">
                    Lihat semua
                </a>
            </div>

            <div class="space-y-3">
                <div class="border border-transparent hover:border-slate-200 hover:bg-slate-50 rounded-xl px-3 py-3 transition-all duration-300">
                    <p class="font-semibold text-slate-800">Canon EOS 80D</p>
                    <p class="text-sm text-slate-500">Ahmad Nasrulloh • 12 Jul 2025 - 14 Jul 2025</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Sudah Bayar</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Booking</span>
                    </div>
                </div>

                <div class="border border-transparent hover:border-slate-200 hover:bg-slate-50 rounded-xl px-3 py-3 transition-all duration-300">
                    <p class="font-semibold text-slate-800">Tenda 4 Orang</p>
                    <p class="text-sm text-slate-500">Putri Audry • 10 Jul 2025 - 13 Jul 2025</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Sudah Bayar</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Sedang Disewa</span>
                    </div>
                </div>

                <div class="border border-transparent hover:border-slate-200 hover:bg-slate-50 rounded-xl px-3 py-3 transition-all duration-300">
                    <p class="font-semibold text-slate-800">Tripod Kamera</p>
                    <p class="text-sm text-slate-500">Budi Santoso • 08 Jul 2025 - 09 Jul 2025</p>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Sudah Bayar</span>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Sudah Dikembalikan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas mini -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 transition-all duration-300 hover:shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-8 rounded-full bg-blue-600"></div>
                <h3 class="text-xl font-bold text-slate-800">Aktivitas Terbaru</h3>
            </div>
            <span class="text-xs text-slate-400">Realtime overview</span>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-4 transition-all duration-300 hover:bg-slate-50 hover:-translate-y-0.5">
                <p class="text-sm font-semibold text-slate-800">Booking baru masuk</p>
                <p class="text-sm text-slate-500 mt-1">USR001 melakukan booking Canon EOS 80D</p>
                <p class="text-xs text-blue-600 mt-2">2 menit lalu</p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-4 transition-all duration-300 hover:bg-slate-50 hover:-translate-y-0.5">
                <p class="text-sm font-semibold text-slate-800">Produk dikembalikan</p>
                <p class="text-sm text-slate-500 mt-1">Tripod Kamera telah selesai disewa</p>
                <p class="text-xs text-blue-600 mt-2">15 menit lalu</p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-4 transition-all duration-300 hover:bg-slate-50 hover:-translate-y-0.5">
                <p class="text-sm font-semibold text-slate-800">User baru terdaftar</p>
                <p class="text-sm text-slate-500 mt-1">Putri Audry berhasil membuat akun</p>
                <p class="text-xs text-blue-600 mt-2">Hari ini</p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-4 transition-all duration-300 hover:bg-slate-50 hover:-translate-y-0.5">
                <p class="text-sm font-semibold text-slate-800">Laporan diperbarui</p>
                <p class="text-sm text-slate-500 mt-1">Data pendapatan bulan ini telah sinkron</p>
                <p class="text-xs text-blue-600 mt-2">Baru saja</p>
            </div>
        </div>
    </div>

</div>
@endsection