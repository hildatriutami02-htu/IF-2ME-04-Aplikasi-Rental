<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <aside class="w-56 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-base font-bold">L</div>
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
            <a href="{{ route('dashboard.admin') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Tabel User</a>
            <a href="{{ route('admin.products') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Katalog Barang</a>
            <a href="{{ route('admin.rentals') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Data Sewa</a>
            <a href="{{ route('admin.reports') }}" class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">Laporan</a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Pengaturan Website</a>
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
                <h2 class="text-2xl font-bold text-slate-800">Laporan</h2>
                <p class="text-sm text-slate-500">Ringkasan data bisnis LensCamp</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-800">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold">A</div>
            </div>
        </header>

        <main class="p-5">
            <div class="max-w-6xl mx-auto space-y-5">

                <div class="grid md:grid-cols-3 gap-5">
                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Total Pendapatan</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">Rp 12.500.000</h3>
                    </div>
                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Transaksi Bulan Ini</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">48</h3>
                    </div>
                    <div class="bg-white rounded-2xl shadow p-5">
                        <p class="text-sm text-slate-500">Pelanggan Aktif</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">74</h3>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-slate-800">Laporan Bulanan</h3>
                        <p class="text-sm text-slate-500">Ringkasan transaksi per bulan</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[900px] text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-5 py-4">Bulan</th>
                                    <th class="px-5 py-4">Pendapatan</th>
                                    <th class="px-5 py-4">Transaksi</th>
                                    <th class="px-5 py-4">Produk Disewa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b">
                                    <td class="px-5 py-4">Januari</td>
                                    <td class="px-5 py-4">Rp 2.500.000</td>
                                    <td class="px-5 py-4">10</td>
                                    <td class="px-5 py-4">18</td>
                                </tr>
                                <tr class="bg-white border-b">
                                    <td class="px-5 py-4">Februari</td>
                                    <td class="px-5 py-4">Rp 3.000.000</td>
                                    <td class="px-5 py-4">12</td>
                                    <td class="px-5 py-4">21</td>
                                </tr>
                                <tr class="bg-white">
                                    <td class="px-5 py-4">Maret</td>
                                    <td class="px-5 py-4">Rp 7.000.000</td>
                                    <td class="px-5 py-4">26</td>
                                    <td class="px-5 py-4">41</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="px-5 py-4 border-t border-gray-200 text-sm text-gray-500">
                        Data laporan terakhir diperbarui hari ini.
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>