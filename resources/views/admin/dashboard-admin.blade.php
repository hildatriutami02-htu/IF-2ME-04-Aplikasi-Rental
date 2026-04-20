<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - LensCamp')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-soft {
            backdrop-filter: blur(10px);
        }

        .animate-fade-up {
            animation: fadeUp 0.5s ease-out forwards;
        }

        .animate-fade-up-delay-1 {
            animation: fadeUp 0.6s ease-out forwards;
        }

        .animate-fade-up-delay-2 {
            animation: fadeUp 0.7s ease-out forwards;
        }

        .animate-fade-up-delay-3 {
            animation: fadeUp 0.8s ease-out forwards;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.5);
            border-radius: 999px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-48 bg-gradient-to-b from-blue-700 via-blue-600 to-blue-500 text-white flex flex-col shadow-xl">
        <div class="px-3 py-3 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/15 glass-soft flex items-center justify-center text-base font-bold text-white shadow-sm ring-1 ring-white/10 transition-all duration-300 hover:scale-105">
                    L
                </div>
                <div>
                    <h1 class="text-lg font-bold text-white tracking-tight">LensCamp</h1>
                    <p class="text-xs text-blue-100">Ruang Admin</p>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-b border-white/10">
            <p class="text-sm text-blue-100">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm leading-6">{{ session('user') }}</h2>
        </div>

        <nav class="flex-1 px-2 py-3 space-y-1 text-sm">
            <a href="{{ route('dashboard.admin') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('dashboard.admin') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Dashboard</span>
                    <span class="{{ request()->routeIs('dashboard.admin') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>

            <a href="{{ route('admin.users') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('admin.users*') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Tabel User</span>
                    <span class="{{ request()->routeIs('admin.users*') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>

            <a href="{{ route('admin.products') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('admin.products*') || request()->routeIs('admin.product.settings*') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Katalog Barang</span>
                    <span class="{{ request()->routeIs('admin.products*') || request()->routeIs('admin.product.settings*') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>

            <a href="{{ route('admin.rentals') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('admin.rentals*') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Data Sewa</span>
                    <span class="{{ request()->routeIs('admin.rentals*') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>

            <a href="{{ route('admin.calendar') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('admin.calendar') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Kalender Rental</span>
                    <span class="{{ request()->routeIs('admin.calendar') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>

            <a href="{{ route('admin.reports') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('admin.reports*') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Laporan</span>
                    <span class="{{ request()->routeIs('admin.reports*') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>

            <a href="{{ route('admin.settings') }}"
               class="group block px-4 py-3 rounded-xl {{ request()->routeIs('admin.settings*') ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }} transition-all duration-300 hover:translate-x-1 hover:shadow-sm">
                <div class="flex items-center justify-between">
                    <span>Pengaturan Website</span>
                    <span class="{{ request()->routeIs('admin.settings*') ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }} transition-all duration-300 group-hover:translate-x-0.5">•</span>
                </div>
            </a>
        </nav>

        <div class="p-3 border-t border-white/10">
            <a href="{{ route('logout') }}"
               class="block w-full text-center px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg">
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white/95 backdrop-blur border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('page_title', 'Dashboard')</h2>
                <p class="text-sm text-slate-500">@yield('page_desc', 'Panel kontrol admin LensCamp')</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-slate-800">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold shadow-sm ring-4 ring-slate-100 transition-all duration-300 hover:scale-105">
                    A
                </div>
            </div>
        </header>

        <main class="p-5">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>