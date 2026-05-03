<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pelanggan - LensCamp' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800">

    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto grid max-w-screen-2xl grid-cols-[auto_1fr_auto] items-center gap-6 px-4 py-4 sm:px-6">

            <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-3 whitespace-nowrap">
               <div class="h-16 w-16 rounded-2xl bg-white p-0 shadow">
   <img src="{{ asset('images/logo-lenscamp.jpeg') }}"
     alt="lenscamp"
     class="w-full h-full object-contain">
</div>

                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">LensCamp</h1>
                    <p class="text-xs text-slate-500">Ruang Pelanggan</p>
                </div>
            </a>

            <nav class="hidden items-center justify-center gap-2 whitespace-nowrap lg:flex">
                <a href="{{ route('pelanggan.dashboard') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Beranda
                </a>

                <a href="{{ route('pelanggan.produk') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.produk') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Produk
                </a>

                <a href="{{ route('pelanggan.keranjang') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.keranjang') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Keranjang
                </a>

                <a href="{{ route('pelanggan.sewa') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.sewa') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Sewa Saya
                </a>

                <a href="{{ route('pelanggan.pembayaran') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.pembayaran') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Pembayaran
                </a>

                <a href="{{ route('pelanggan.riwayat') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.riwayat') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Riwayat
                </a>

                <a href="{{ route('pelanggan.hubungi-admin') }}"
                   class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.hubungi-admin') ? 'bg-blue-600 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                    Bantuan
                </a>
            </nav>

            <div class="flex items-center justify-end gap-3 whitespace-nowrap">
                <div class="hidden text-right leading-tight md:block">
                    <p class="text-sm font-semibold text-slate-800">Pelanggan</p>
                    <p class="max-w-[180px] truncate text-xs text-slate-500">
                        {{ session('user') ?? 'pelanggan@email.com' }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-800 text-xl font-bold text-white shadow-sm">
                    {{ strtoupper(substr(session('user') ?? 'P', 0, 1)) }}
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 bg-white lg:hidden">
            <div class="mx-auto flex max-w-screen-2xl gap-2 overflow-x-auto px-4 py-3 sm:px-6">
                <a href="{{ route('pelanggan.dashboard') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.dashboard') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Beranda
                </a>

                <a href="{{ route('pelanggan.produk') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.produk') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Produk
                </a>

                <a href="{{ route('pelanggan.keranjang') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.keranjang') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Keranjang
                </a>

                <a href="{{ route('pelanggan.sewa') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.sewa') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Sewa Saya
                </a>

                <a href="{{ route('pelanggan.pembayaran') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.pembayaran') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Pembayaran
                </a>

                <a href="{{ route('pelanggan.riwayat') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.riwayat') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Riwayat
                </a>

                <a href="{{ route('pelanggan.hubungi-admin') }}"
                   class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.hubungi-admin') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    Bantuan
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-screen-2xl px-4 py-6 sm:px-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-800">
                {{ $headerTitle ?? 'Dashboard Pelanggan' }}
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                {{ $headerDesc ?? 'Pantau aktivitas akun kamu' }}
            </p>
        </div>

        @yield('content')

        <div class="mt-10 border-t border-slate-200 pt-6">
            <a href="{{ route('home') }}"
               class="inline-flex rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                Kembali ke Home
            </a>
        </div>
    </main>

</body>
</html>