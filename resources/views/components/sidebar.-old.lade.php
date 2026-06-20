<aside class="fixed inset-y-0 left-0 z-30 hidden w-80 lg:flex flex-col bg-gradient-to-b from-[#1E3932] via-[#2F5249] to-[#437057] text-white shadow-xl">

    <div class="px-6 py-7 border-b border-white/10">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-2xl bg-white p-0 shadow">
                <img src="{{ asset('images/logo-lenscamp.jpeg') }}"
                     alt="LensCamp"
                     class="w-full h-full object-contain">
            </div>

            <div class="min-w-0">
                <h1 class="text-3xl font-extrabold tracking-tight leading-none">
                    LensCamp
                </h1>
                <p class="mt-1 text-base text-[#DDE8DF]">
                    Ruang Pelanggan
                </p>
            </div>
        </div>
    </div>

    <div class="px-6 py-6 border-b border-white/10">
        <p class="text-sm text-[#DDE8DF]">Halo, Pelanggan</p>

        <h2 class="mt-3 text-xl font-bold text-white break-words leading-snug">
            {{ session('user') ?? 'pelanggan@email.com' }}
        </h2>
    </div>

    <nav class="flex-1 px-5 py-6 space-y-3">
        <a href="{{ route('pelanggan.dashboard') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.dashboard') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Dashboard
        </a>

        <a href="{{ route('pelanggan.produk') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.produk') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Produk
        </a>

        <a href="{{ route('pelanggan.sewa') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.sewa') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Sewa Saya
        </a>

        <a href="{{ route('pelanggan.pembayaran') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.pembayaran') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Pembayaran
        </a>

        <a href="{{ route('pelanggan.riwayat') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.riwayat') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Riwayat Sewa
        </a>

        <a href="{{ route('pelanggan.profil') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.profil') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Profil Saya
        </a>

        <a href="{{ route('pelanggan.hubungi-admin') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition
           {{ request()->routeIs('pelanggan.hubungi-admin') ? 'bg-white text-[#2F5249] shadow-sm' : 'text-[#F1F6F2] hover:bg-white/10' }}">
            Hubungi Admin
        </a>
    </nav>

    <div class="px-5 py-5 border-t border-white/10 space-y-3">
        <a href="{{ route('home') }}"
           class="block w-full rounded-2xl bg-[#2F5249] px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-[#437057]">
            ← Kembali ke Home
        </a>

        <a href="{{ route('logout') }}"
           class="block w-full rounded-2xl bg-red-600 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-red-700">
            Keluar
        </a>
    </div>
</aside>