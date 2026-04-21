<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <aside class="w-56 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-base font-bold">
                    L
                </div>
                <div>
                    <h1 class="text-lg font-bold">LensCamp</h1>
                    <p class="text-xs text-slate-300">Ruang Admin</p>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-b border-slate-700">
            <p class="text-sm text-slate-300">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm">{{ session('user') }}</h2>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-2 text-sm">
            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">
                Dashboard
            </a>
            <a href="{{ route('admin.users') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Tabel User
            </a>
            <a href="{{ route('admin.products') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Katalog Barang
            </a>
            <a href="{{ route('admin.rentals') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Data Sewa
            </a>
            <a href="{{ route('admin.reports') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Laporan
            </a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">
                Pengaturan Website
            </a>
        </nav>

        <div class="p-3 border-t border-slate-700">
            <a href="{{ route('logout') }}" class="block w-full text-center px-4 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold text-sm">
                Keluar
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Dashboard</h2>
                <p class="text-sm text-slate-500">Panel kontrol admin LensCamp</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-800">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">
                    A
                </div>
            </div>
        </header>

        <main class="p-5">
            <div class="max-w-6xl mx-auto space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Pendapatan</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">Rp 12.500.000</h3>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Total Rental</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">48 Transaksi</h3>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Total User</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">126 User</h3>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Produk</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">32 Barang</h3>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
                    <div class="bg-white rounded-2xl shadow p-5">
                        <h3 class="text-xl font-bold text-slate-800 mb-5">Menu Cepat</h3>
                        <div class="space-y-4">
                            <a href="{{ route('admin.users') }}" class="block px-5 py-4 rounded-xl bg-blue-50 text-blue-700 font-semibold hover:bg-blue-100 transition">
                                Kelola Tabel User
                            </a>
                            <a href="{{ route('admin.products') }}" class="block px-5 py-4 rounded-xl bg-green-50 text-green-700 font-semibold hover:bg-green-100 transition">
                                Kelola Katalog Barang
                            </a>
                            <a href="{{ route('admin.rentals') }}" class="block px-5 py-4 rounded-xl bg-yellow-50 text-yellow-700 font-semibold hover:bg-yellow-100 transition">
                                Kelola Data Sewa
                            </a>
                            <a href="{{ route('admin.reports') }}" class="block px-5 py-4 rounded-xl bg-purple-50 text-purple-700 font-semibold hover:bg-purple-100 transition">
                                Lihat Laporan
                            </a>
                        </div>
                    </div>

                    <div class="xl:col-span-2 bg-white rounded-2xl shadow p-5">
                        <h3 class="text-xl font-bold text-slate-800 mb-5">Ringkasan Aktivitas</h3>

                        <div class="grid md:grid-cols-2 gap-5">
                            <div class="rounded-2xl bg-slate-100 p-5">
                                <p class="text-sm text-slate-500">Booking</p>
                                <h4 class="text-2xl font-bold text-slate-800 mt-3">12</h4>
                            </div>

                            <div class="rounded-2xl bg-slate-100 p-5">
                                <p class="text-sm text-slate-500">Sedang Disewa</p>
                                <h4 class="text-2xl font-bold text-slate-800 mt-3">19</h4>
                            </div>

                            <div class="rounded-2xl bg-slate-100 p-5">
                                <p class="text-sm text-slate-500">Sudah Dikembalikan</p>
                                <h4 class="text-2xl font-bold text-slate-800 mt-3">8</h4>
                            </div>

                            <div class="rounded-2xl bg-slate-100 p-5">
                                <p class="text-sm text-slate-500">User Aktif</p>
                                <h4 class="text-2xl font-bold text-slate-800 mt-3">74</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                    <div class="bg-white rounded-2xl shadow p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-slate-800">User Terbaru</h3>
                            <a href="{{ route('admin.users') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between border-b pb-3">
                                <div>
                                    <p class="font-semibold text-slate-800">USR001 - Ahmad Nasrulloh</p>
                                    <p class="text-sm text-slate-500">Terdaftar hari ini</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                            </div>

                            <div class="flex items-center justify-between border-b pb-3">
                                <div>
                                    <p class="font-semibold text-slate-800">USR002 - Putri Audry</p>
                                    <p class="text-sm text-slate-500">Terdaftar kemarin</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-slate-800">USR003 - Budi Santoso</p>
                                    <p class="text-sm text-slate-500">Terdaftar 2 hari lalu</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Baru</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-slate-800">Riwayat Rental Terbaru</h3>
                            <a href="{{ route('admin.rentals') }}" class="text-sm text-blue-600 hover:underline">Lihat semua</a>
                        </div>

                        <div class="space-y-4">
                            <div class="border-b pb-3">
                                <p class="font-semibold text-slate-800">Canon EOS 80D</p>
                                <p class="text-sm text-slate-500">Ahmad Nasrulloh • 12 Jul 2025 - 14 Jul 2025</p>
                                <div class="mt-2 flex gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sudah Bayar</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Booking</span>
                                </div>
                            </div>

                            <div class="border-b pb-3">
                                <p class="font-semibold text-slate-800">Tenda 4 Orang</p>
                                <p class="text-sm text-slate-500">Putri Audry • 10 Jul 2025 - 13 Jul 2025</p>
                                <div class="mt-2 flex gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sudah Bayar</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Sedang Disewa</span>
                                </div>
                            </div>

                            <div>
                                <p class="font-semibold text-slate-800">Tripod Kamera</p>
                                <p class="text-sm text-slate-500">Budi Santoso • 08 Jul 2025 - 09 Jul 2025</p>
                                <div class="mt-2 flex gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sudah Bayar</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Sudah Dikembalikan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>