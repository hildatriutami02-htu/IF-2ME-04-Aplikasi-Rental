<aside class="fixed inset-y-0 left-0 z-30 hidden w-80 lg:flex flex-col bg-slate-900 text-white border-r border-slate-800 shadow-xl">
    <div class="px-6 py-7 border-b border-slate-800">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-3xl bg-blue-600 flex items-center justify-center text-2xl font-extrabold shadow-lg">
                L
            </div>
            <div class="min-w-0">
                <h1 class="text-3xl font-extrabold tracking-tight leading-none">LensCamp</h1>
                <p class="mt-1 text-base text-slate-300">Ruang Pelanggan</p>
            </div>
        </div>
    </div>

    <div class="px-6 py-6 border-b border-slate-800">
        <p class="text-sm text-slate-300">Halo, Pelanggan</p>
        <h2 class="mt-3 text-xl font-bold text-white break-words leading-snug">
            {{ session('user') ?? 'pelanggan@email.com' }}
        </h2>
    </div>

    <nav class="flex-1 px-5 py-6 space-y-3">
        <a href="{{ route('pelanggan.dashboard') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Dashboard
        </a>

        <a href="{{ route('pelanggan.produk') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.produk') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Produk
        </a>

        <a href="{{ route('pelanggan.sewa') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.sewa') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Sewa Saya
        </a>

        <a href="{{ route('pelanggan.pembayaran') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.pembayaran') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Pembayaran
        </a>

        <a href="{{ route('pelanggan.riwayat') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.riwayat') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Riwayat Sewa
        </a>

        <a href="{{ route('pelanggan.profil') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.profil') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Profil Saya
        </a>

        <a href="{{ route('pelanggan.hubungi-admin') }}"
           class="block rounded-2xl px-5 py-4 text-base font-semibold transition {{ request()->routeIs('pelanggan.hubungi-admin') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-200 hover:bg-slate-800' }}">
            Hubungi Admin
        </a>
    </nav>

    <div class="px-5 py-5 border-t border-slate-800 space-y-3">
        <a href="{{ route('home') }}"
           class="block w-full rounded-2xl bg-slate-800 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-700">
            ← Kembali ke Home
        </a>

        <a href="{{ route('logout') }}"
           class="block w-full rounded-2xl bg-red-600 px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-red-700">
            Keluar
        </a>
    </div>
</aside>