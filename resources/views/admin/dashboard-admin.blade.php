<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - LensCamp')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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
                    ['route' => 'admin.calendar', 'label' => 'Kalender Rental'],
                    ['route' => 'admin.reports', 'label' => 'Laporan'],
                    ['route' => 'admin.settings', 'label' => 'Informasi Website'],
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
    </aside>

    <div class="flex-1 flex flex-col">

        <header class="bg-white/95 backdrop-blur border-b border-[#dfe7df] px-6 py-4 flex justify-between items-center sticky top-0 z-20">
            <div>
                <h2 class="text-2xl font-bold text-[#2F5249]">@yield('page_title')</h2>
                <p class="text-sm text-slate-500">@yield('page_desc')</p>
            </div>

            <div x-data="{ open: false }" class="relative">
    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-3 rounded-2xl px-3 py-2 hover:bg-[#eef3ee] transition"
    >
        <p class="text-sm font-semibold text-[#2F5249]">Admin</p>

        <div class="w-10 h-10 rounded-full bg-[#2F5249] text-white flex items-center justify-center font-bold shadow-sm ring-4 ring-[#eef3ee]">
            A
        </div>
    </button>

    <div
    x-show="open"
    @click.away="open = false"
    x-transition
    class="absolute right-0 mt-3 w-52 rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden z-50"
    style="display: none;"
>
    <a href="{{ route('admin.password.edit') }}"
       class="block px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-[#F8FAF7]">
         Ganti Password
    </a>

    <div class="border-t border-slate-100"></div>

    <a href="{{ route('logout') }}"
       class="block px-5 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">
         Keluar
    </a>
</div>

</div>
        </header>

        <main class="p-5">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
<script>
    feather.replace();
</script>

</body>
</html>