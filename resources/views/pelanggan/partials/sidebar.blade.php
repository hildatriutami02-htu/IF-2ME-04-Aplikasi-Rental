@php
    $customerMenu = [
        ['route' => 'pelanggan.dashboard', 'label' => 'Dashboard'],
        ['route' => 'pelanggan.produk', 'label' => 'Produk'],
        ['route' => 'pelanggan.keranjang', 'label' => 'Keranjang'],
        ['route' => 'pelanggan.sewa', 'label' => 'Sewa Saya'],
        ['route' => 'pelanggan.pembayaran', 'label' => 'Pembayaran'],
        ['route' => 'pelanggan.riwayat', 'label' => 'Riwayat Sewa'],
        ['route' => 'pelanggan.profil', 'label' => 'Profil Saya'],
        ['route' => 'pelanggan.hubungi-admin', 'label' => 'Hubungi Admin'],
    ];

    $menuClass = 'block rounded-2xl px-5 py-4 text-base font-semibold transition';

    $activeClass = 'bg-[#2F5249] text-white shadow-sm';

    $inactiveClass = 'text-slate-300 hover:bg-[#437057] hover:text-white';
@endphp

<aside class="fixed inset-y-0 left-0 z-30 hidden w-80 lg:flex flex-col bg-[#1E2E24] text-white border-r border-[#2F5249] shadow-xl">

    <!-- HEADER -->
    <div class="px-6 py-7 border-b border-[#2F5249]">
        <div class="flex items-center gap-4">

            <div class="w-16 h-16 rounded-3xl bg-[#2F5249] flex items-center justify-center text-2xl font-extrabold shadow-lg">
                🌲
            </div>

            <div class="min-w-0">
                <h1 class="text-3xl font-extrabold tracking-tight leading-none">
                    LensCamp
                </h1>

                <p class="mt-1 text-base text-[#A7C1A8]">
                    Ruang Pelanggan
                </p>
            </div>

        </div>
    </div>

    <!-- USER -->
    <div class="px-6 py-6 border-b border-[#2F5249]">

        <p class="text-sm text-[#A7C1A8]">
            Halo, Pelanggan
        </p>

        <h2 class="mt-3 text-xl font-bold text-white break-words leading-snug">
            {{ session('user') ?? 'pelanggan@email.com' }}
        </h2>

    </div>

    <!-- MENU -->
    <nav class="flex-1 px-5 py-6 space-y-3">

        @foreach ($customerMenu as $item)
            <a
                href="{{ route($item['route']) }}"
                class="{{ $menuClass }} {{ request()->routeIs($item['route']) ? $activeClass : $inactiveClass }}"
            >
                {{ $item['label'] }}
            </a>
        @endforeach

    </nav>

    <!-- FOOTER -->
    <div class="px-5 py-5 border-t border-[#2F5249] space-y-3">

        <a
            href="{{ route('home') }}"
            class="block w-full rounded-2xl bg-[#2F5249] px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-[#437057]"
        >
            ← Kembali ke Home
        </a>

        <a
            href="{{ route('logout') }}"
            class="block w-full rounded-2xl bg-red-600 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-red-700"
        >
            Keluar
        </a>

    </div>

</aside>