<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Pelanggan - LensCamp' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }
    </style>
</head>

<body class="bg-[#F8FAF7] text-slate-800">

<header class="sticky top-0 z-30 border-b border-[#dfe7df] bg-white/95 backdrop-blur">
    <div class="mx-auto grid max-w-screen-2xl grid-cols-[auto_1fr_auto] items-center gap-6 px-4 py-4 sm:px-6">

        <a href="{{ route('pelanggan.dashboard') }}" class="flex items-center gap-3 whitespace-nowrap">
            <div class="h-16 w-16 rounded-2xl bg-white shadow">
                <img src="{{ asset('images/logo-lenscamp.jpeg') }}"
                     alt="LensCamp"
                     class="h-full w-full object-contain">
            </div>

            <div>
                <h1 class="text-xl font-bold tracking-tight text-[#2F5249]">LensCamp</h1>
                <p class="text-xs text-[#437057]">Ruang Pelanggan</p>
            </div>
        </a>

        <nav class="hidden items-center justify-center gap-2 whitespace-nowrap lg:flex">
            <a href="{{ route('pelanggan.dashboard') }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.dashboard') ? 'bg-[#2F5249] text-white' : 'text-slate-700 hover:bg-[#eef3ee]' }}">
                Beranda
            </a>

            <a href="{{ route('pelanggan.produk') }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.produk') ? 'bg-[#2F5249] text-white' : 'text-slate-700 hover:bg-[#eef3ee]' }}">
                Produk
            </a>

            <a href="{{ route('pelanggan.keranjang') }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.keranjang') ? 'bg-[#2F5249] text-white' : 'text-slate-700 hover:bg-[#eef3ee]' }}">
                Keranjang
            </a>

            <a href="{{ route('pelanggan.sewa') }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.sewa') ? 'bg-[#2F5249] text-white' : 'text-slate-700 hover:bg-[#eef3ee]' }}">
                Sewa Saya
            </a>

            <a href="{{ route('pelanggan.pembayaran') }}"
            class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.pembayaran') ? 'bg-[#2F5249] text-white' : 'text-slate-700 hover:bg-[#eef3ee]' }}">
                Pembayaran
            </a>

            <a href="{{ route('pelanggan.riwayat') }}"
               class="rounded-xl px-4 py-2 text-sm font-medium transition {{ request()->routeIs('pelanggan.riwayat') ? 'bg-[#2F5249] text-white' : 'text-slate-700 hover:bg-[#eef3ee]' }}">
                Riwayat
            </a>
        </nav>

        <div class="relative" id="accountDropdown">
            <button type="button"
                    onclick="toggleAccountMenu()"
                    class="flex items-center gap-3 rounded-2xl px-3 py-2 transition hover:bg-[#eef3ee]">

                <div class="hidden text-right leading-tight md:block">
                    <p class="text-sm font-semibold text-[#2F5249]">
                        {{ session('nama') ?? 'Pelanggan' }}
                    </p>

                    <p class="max-w-[180px] truncate text-xs text-slate-500">
                        {{ session('user') ?? 'pelanggan@email.com' }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#2F5249] text-xl font-bold text-white shadow-sm">
                    {{ strtoupper(substr(session('nama') ?? 'P', 0, 1)) }}
                </div>
            </button>

           <div id="accountMenu"
     class="absolute right-0 mt-3 hidden w-56 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl bg-white">

    <a href="{{ route('pelanggan.profil') }}"
       class="block px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-[#eef3ee]">
        Profil Saya
    </a>

    <a href="{{ route('logout') }}"
       class="block px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50">
        Keluar
    </a>

</div>
        </div>
    </div>

    <div class="border-t border-[#dfe7df] bg-white lg:hidden">
        <div class="mx-auto flex max-w-screen-2xl gap-2 overflow-x-auto px-4 py-3 sm:px-6">
            <a href="{{ route('pelanggan.dashboard') }}"
               class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.dashboard') ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249]' }}">
                Beranda
            </a>

            <a href="{{ route('pelanggan.produk') }}"
               class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.produk') ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249]' }}">
                Produk
            </a>

            <a href="{{ route('pelanggan.keranjang') }}"
               class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.keranjang') ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249]' }}">
                Keranjang
            </a>

            <a href="{{ route('pelanggan.sewa') }}"
               class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.sewa') ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249]' }}">
                Sewa Saya
            </a>

            <a href="{{ route('pelanggan.pembayaran') }}"
               class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.pembayaran') ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249]' }}">
                Pembayaran
            </a>

            <a href="{{ route('pelanggan.riwayat') }}"
               class="whitespace-nowrap rounded-xl px-4 py-2 text-sm font-medium {{ request()->routeIs('pelanggan.riwayat') ? 'bg-[#2F5249] text-white' : 'bg-[#eef3ee] text-[#2F5249]' }}">
                Riwayat
            </a>
        </div>
    </div>
</header>

<main class="mx-auto max-w-screen-2xl px-4 py-6 sm:px-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-[#2F5249]">
            {{ $headerTitle ?? 'Dashboard Pelanggan' }}
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ $headerDesc ?? 'Pantau aktivitas akun kamu' }}
        </p>
    </div>

    @yield('content')
</main>

<script>
function toggleAccountMenu() {
    document.getElementById('accountMenu').classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('accountDropdown');

    if (!dropdown.contains(e.target)) {
        document.getElementById('accountMenu').classList.add('hidden');
    }
});
</script>

</body>
</html>