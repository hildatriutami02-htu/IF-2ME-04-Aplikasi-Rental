<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Admin - LensCamp')</title>

    <!-- Tailwind & Flowbite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body { font-family: 'Inter', sans-serif; }

        .glass-soft { backdrop-filter: blur(10px); }

        .animate-fade-up { animation: fadeUp 0.5s ease-out forwards; }
        .animate-fade-up-delay-1 { animation: fadeUp 0.6s ease-out forwards; }
        .animate-fade-up-delay-2 { animation: fadeUp 0.7s ease-out forwards; }
        .animate-fade-up-delay-3 { animation: fadeUp 0.8s ease-out forwards; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
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

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-48 bg-gradient-to-b from-blue-700 via-blue-600 to-blue-500 text-white flex flex-col shadow-xl">

        <!-- Logo -->
        <div class="px-3 py-3 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/15 glass-soft flex items-center justify-center text-base font-bold text-white shadow-sm ring-1 ring-white/10 hover:scale-105 transition">
                    L
                </div>
                <div>
                    <h1 class="text-lg font-bold">LensCamp</h1>
                    <p class="text-xs text-blue-100">Ruang Admin</p>
                </div>
            </div>
        </div>

        <!-- User -->
        <div class="px-4 py-4 border-b border-white/10">
            <p class="text-sm text-blue-100">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm">{{ session('user') }}</h2>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-2 py-3 space-y-1 text-sm">

            @php
                $menu = [
                    ['route' => 'dashboard.admin', 'label' => 'Dashboard'],
                    ['route' => 'admin.users.index', 'label' => 'Tabel User'],
                    ['route' => 'admin.products', 'label' => 'Katalog Barang'],
                    ['route' => 'admin.rentals', 'label' => 'Data Sewa'],
                    ['route' => 'admin.calendar', 'label' => 'Kalender Rental'],
                    ['route' => 'admin.reports', 'label' => 'Laporan'],
                    ['route' => 'admin.settings', 'label' => 'Pengaturan Website'],
                ];
            @endphp

            @foreach ($menu as $item)
                @php
                    $active = request()->routeIs($item['route'].'*');
                @endphp

                <a href="{{ route($item['route']) }}"
                   class="group block px-4 py-3 rounded-xl
                   {{ $active ? 'bg-white text-blue-700 font-semibold shadow-sm' : 'hover:bg-white/10 text-blue-50' }}
                   transition-all duration-300 hover:translate-x-1 hover:shadow-sm">

                    <div class="flex items-center justify-between">
                        <span>{{ $item['label'] }}</span>
                        <span class="{{ $active ? 'text-blue-500' : 'opacity-0 group-hover:opacity-100' }}">•</span>
                    </div>
                </a>
            @endforeach

        </nav>

        <!-- Logout -->
        <div class="p-3 border-t border-white/10">
            <a href="{{ route('logout') }}"
               class="block w-full text-center px-4 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold text-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                Keluar
            </a>
        </div>
    </aside>

    <!-- ================= MAIN ================= -->
    <div class="flex-1 flex flex-col">

        <!-- Header -->
        <header class="bg-white/95 backdrop-blur border-b border-slate-200 px-6 py-4 flex justify-between items-center sticky top-0 z-20">
            <div>
                <h2 class="text-2xl font-bold">@yield('page_title')</h2>
                <p class="text-sm text-slate-500">@yield('page_desc')</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>

                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold shadow-sm ring-4 ring-slate-100 hover:scale-105 transition">
                    A
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="p-5">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

</body>
</html>