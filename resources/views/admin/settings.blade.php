<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Website - LensCamp</title>

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
            <a href="{{ route('admin.reports') }}" class="block px-4 py-3 rounded-lg hover:bg-slate-700 text-slate-200">Laporan</a>
            <a href="{{ route('admin.settings') }}" class="block px-4 py-3 rounded-lg bg-blue-600 text-white font-semibold">Pengaturan Website</a>
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
                <h2 class="text-2xl font-bold text-slate-800">Pengaturan Website</h2>
                <p class="text-sm text-slate-500">Atur informasi dasar website</p>
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
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow">
                    <div class="px-5 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-slate-800">Form Pengaturan</h3>
                        <p class="text-sm text-slate-500">Perbarui informasi dasar website LensCamp</p>
                    </div>

                    <form class="p-5 space-y-5">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Website</label>
                            <input type="text" value="LensCamp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Email Admin</label>
                            <input type="email" value="admin@lenscamp.com" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor WhatsApp</label>
                            <input type="text" value="081234567890" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                            <textarea rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl block w-full p-3">Batam, Indonesia</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>