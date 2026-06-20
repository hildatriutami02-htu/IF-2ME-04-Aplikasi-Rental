<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - LensCamp')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            background: rgba(47, 82, 73, 0.45);
            border-radius: 999px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>
</head>

<body class="bg-[#F8FAF7] text-slate-800">

<div class="flex min-h-screen">

    <aside class="w-48 bg-gradient-to-b from-[#1E3932] via-[#2F5249] to-[#437057] text-white flex flex-col shadow-xl">

        <div class="px-3 py-3 border-b border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-white p-0 shadow">
                    <img src="{{ asset('images/logo-lenscamp.jpeg') }}"
                         alt="LensCamp"
                         class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-lg font-bold">LensCamp</h1>
                    <p class="text-xs text-[#DDE8DF]">Ruang Admin</p>
                </div>
            </div>
        </div>

        <div class="px-4 py-4 border-b border-white/10">
            <p class="text-sm text-[#DDE8DF]">Halo, Admin</p>
            <h2 class="font-semibold text-white break-all text-sm">{{ session('user') }}</h2>
        </div>

        <nav class="flex-1 px-2 py-3 space-y-1 text-sm">

            @php
                $menu = [
                    ['route' => 'dashboard.admin', 'label' => 'Dashboard'],
                    ['route' => 'admin.products', 'label' => 'Katalog Barang'],
                    ['route' => 'admin.rentals', 'label' => 'Data Sewa'],
                    ['route' => 'admin.payments', 'label' => 'Pembayaran'],
                    ['route' => 'admin.calendar', 'label' => 'Kalender Rental'],
                    ['route' => 'admin.reports', 'label' => 'Laporan'],
                    ['route' => 'admin.settings', 'label' => 'Pengaturan Sistem'],
                ];
            @endphp

            @foreach ($menu as $item)
                @php
                    $active = request()->routeIs($item['route'].'*');
                @endphp

                <a href="{{ route($item['route']) }}"
                   class="group block px-4 py-3 rounded-xl
                   {{ $active ? 'bg-white text-[#2F5249] font-semibold shadow-sm' : 'hover:bg-white/10 text-[#F1F6F2]' }}
                   transition-all duration-300 hover:translate-x-1 hover:shadow-sm">

                    <div class="flex items-center justify-between">
                        <span>{{ $item['label'] }}</span>
                        <span class="{{ $active ? 'text-[#437057]' : 'opacity-0 group-hover:opacity-100' }}">•</span>
                    </div>
                </a>
            @endforeach

        </nav>

        <div class="p-3 border-t border-white/10">
            <a href="{{ route('logout') }}"
               class="block w-full text-center px-4 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                Keluar
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">

        <header class="bg-white/95 backdrop-blur border-b border-[#dfe7df] px-6 py-4 flex justify-between items-center sticky top-0 z-20">
            <div>
                <h2 class="text-2xl font-bold text-[#2F5249]">@yield('page_title')</h2>
                <p class="text-sm text-slate-500">@yield('page_desc')</p>
            </div>

            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-semibold text-[#2F5249]">Admin</p>
                    <p class="text-xs text-slate-500">{{ session('user') }}</p>
                </div>

                <div class="w-10 h-10 rounded-full bg-[#2F5249] text-white flex items-center justify-center font-bold shadow-sm ring-4 ring-[#eef3ee] hover:scale-105 transition">
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