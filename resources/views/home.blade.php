<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LensCamp</title>

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
<body class="bg-slate-50 text-slate-800">

    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-extrabold shadow">
                    L
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">LensCamp</h1>
                    <p class="text-xs text-slate-500">
                        {{ $isPelanggan ? 'Beranda Aplikasi' : 'Sewa perlengkapan dengan cepat' }}
                    </p>
                </div>
            </div>

            @if($isPelanggan)
                <div class="flex items-center gap-3">
                    <a href="{{ route('pelanggan.produk') }}"
                       class="hidden sm:inline-flex rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                        Produk
                    </a>

                    <a href="{{ route('pelanggan.sewa') }}"
                       class="hidden sm:inline-flex rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                        Sewa Saya
                    </a>

                    <a href="{{ route('pelanggan.pembayaran') }}"
                       class="hidden sm:inline-flex rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                        Pembayaran
                    </a>

                    <a href="{{ route('logout') }}"
                       class="inline-flex rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition">
                        Keluar
                    </a>
                </div>
            @else
                <nav class="hidden md:flex items-center gap-6">
                    <a href="#beranda" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Beranda</a>
                    <a href="#tentang" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Tentang</a>
                    <a href="#produk" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Produk</a>
                    <a href="#hubungi-kami" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Hubungi Kami</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                       class="inline-flex rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                        Masuk
                    </a>

                    <a href="{{ route('daftar') }}"
                       class="inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Daftar
                    </a>
                </div>
            @endif
        </div>
    </header>

    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 py-8 space-y-16">

        @if(session('success'))
            <div class="rounded-2xl bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($isPelanggan)
            <section id="beranda" class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-6 sm:p-8 text-white shadow-lg">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-center">
                    <div class="lg:col-span-2">
                        <p class="text-sm font-medium text-blue-100">Halo, {{ session('user') ?? 'Pelanggan' }}</p>
                        <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                            Mau sewa apa hari ini?
                        </h2>
                        <p class="mt-3 text-sm sm:text-base text-blue-50 max-w-2xl">
                            Pilih produk, tentukan tanggal sewa, lalu ajukan pesanan langsung dari beranda aplikasi.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="#produk"
                               class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-slate-100 transition">
                                Lihat Produk
                            </a>
                            <a href="{{ route('pelanggan.hubungi-admin') }}"
                               class="rounded-2xl bg-blue-700/40 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-blue-700/60 transition">
                                Hubungi Admin
                            </a>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur rounded-3xl p-5 ring-1 ring-white/15">
                        <h3 class="text-lg font-bold">Ringkasan Akun</h3>
                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                                <span>Sewa Aktif</span>
                                <span class="font-bold">{{ count($customerRentals) }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                                <span>Pembayaran</span>
                                <span class="font-bold">{{ count($paymentHistory) }}</span>
                            </div>
                            <div class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                                <span>Status</span>
                                <span class="font-bold">Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            @if($pickupReminder)
                <section class="rounded-3xl border border-blue-200 bg-blue-50 p-5 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-blue-700">Reminder Pesanan</p>
                            <h3 class="mt-1 text-lg font-bold text-slate-800">
                                {{ $pickupReminder['nama_barang'] ?? '-' }}
                            </h3>
                            <p class="mt-1 text-sm text-slate-600">
                                Tanggal sewa: {{ $pickupReminder['tanggal_pinjam'] ?? '-' }} sampai {{ $pickupReminder['tanggal_kembali'] ?? '-' }}
                            </p>
                        </div>

                        <a href="{{ route('pelanggan.sewa') }}"
                           class="inline-flex w-fit rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition">
                            Lihat Pesanan
                        </a>
                    </div>
                </section>
            @endif

        @else
            <section id="beranda" class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-6 sm:p-10 text-white shadow-lg">
                <div class="max-w-3xl">
                    <p class="text-sm font-medium text-blue-100">Outdoor & Visual Rental</p>
                    <h2 class="mt-2 text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                        Sewa perlengkapan lebih cepat dan lebih praktis.
                    </h2>
                    <p class="mt-4 text-sm sm:text-base text-blue-50 max-w-2xl">
                        Login untuk langsung memesan produk, pilih tanggal sewa, dan pantau pembayaran dari satu beranda aplikasi.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('login') }}"
                           class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 hover:bg-slate-100 transition">
                            Masuk Sekarang
                        </a>
                        <a href="{{ route('daftar') }}"
                           class="rounded-2xl bg-blue-700/40 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/20 hover:bg-blue-700/60 transition">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </section>

            <section id="tentang" class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                <div>
                    <p class="text-sm font-semibold text-blue-600">Tentang LensCamp</p>
                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        Rental perlengkapan outdoor yang simpel dan cepat.
                    </h3>
                    <p class="mt-4 text-slate-600 leading-7">
                        LensCamp membantu pelanggan menyewa perlengkapan outdoor dan perlengkapan visual dengan proses yang lebih mudah.
                        Mulai dari pilih produk, tentukan tanggal sewa, hingga pembayaran, semua dilakukan dalam satu alur yang sederhana.
                    </p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-sm text-slate-500">Produk Tersedia</p>
                            <p class="mt-2 text-2xl font-bold text-slate-800">50+</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-sm text-slate-500">Pelanggan</p>
                            <p class="mt-2 text-2xl font-bold text-slate-800">100+</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-sm text-slate-500">Transaksi</p>
                            <p class="mt-2 text-2xl font-bold text-slate-800">300+</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-5">
                            <p class="text-sm text-slate-500">Layanan</p>
                            <p class="mt-2 text-2xl font-bold text-slate-800">Cepat</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section id="produk" class="space-y-5">
            <div>
                <h3 class="text-2xl font-bold text-slate-800">
                    {{ $isPelanggan ? 'Pesan Produk Sekarang' : 'Produk Populer' }}
                </h3>
                <p class="text-sm text-slate-500 mt-1">
                    {{ $isPelanggan ? 'Pilih produk dan langsung ajukan sewa dari sini.' : 'Jelajahi perlengkapan terbaik yang tersedia.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $item)
                    <div class="bg-white rounded-3xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">
                        <div class="h-44 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-4xl font-bold">
                            {{ strtoupper(substr($item['nama_barang'], 0, 1)) }}
                        </div>

                        <div class="mt-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800">{{ $item['nama_barang'] }}</h4>
                                    <p class="text-sm text-slate-500 mt-1">{{ $item['jenis_barang'] }}</p>
                                </div>
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                    Stok {{ $item['unit'] }}
                                </span>
                            </div>

                            <p class="mt-3 text-sm text-slate-500">
                                {{ $item['deskripsi'] }}
                            </p>

                            <p class="mt-4 text-base font-bold text-blue-600">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }} / hari
                            </p>
                        </div>

                        @if($isPelanggan)
                            <form action="{{ route('pelanggan.sewa.store', $item['id']) }}" method="POST" class="mt-5 space-y-3">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Tanggal Pinjam</label>
                                        <input type="date" name="tanggal_pinjam"
                                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Tanggal Kembali</label>
                                        <input type="date" name="tanggal_kembali"
                                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-[110px_1fr] gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Qty</label>
                                        <input type="number" name="qty" min="1" max="{{ $item['unit'] }}" value="1"
                                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-slate-600 mb-1">Catatan</label>
                                        <input type="text" name="catatan" placeholder="Opsional"
                                            class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit"
                                        class="rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                                        Sewa Sekarang
                                    </button>

                                    <a href="{{ route('pelanggan.hubungi-admin') }}"
                                       class="rounded-xl bg-slate-100 px-4 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                                        Tanya Admin
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <a href="{{ route('login') }}"
                                   class="rounded-xl bg-blue-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-blue-700 transition">
                                    Login
                                </a>

                                <a href="#hubungi-kami"
                                   class="rounded-xl bg-slate-100 px-4 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                                    Tanya Admin
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        @if(!$isPelanggan)
            <section id="hubungi-kami" class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
                    <div>
                        <p class="text-sm font-semibold text-blue-600">Hubungi Kami</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">
                            Butuh bantuan sebelum menyewa?
                        </h3>
                        <p class="mt-4 text-slate-600 leading-7">
                            Hubungi admin kami untuk tanya stok barang, durasi sewa, atau bantuan proses pemesanan.
                        </p>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Email</p>
                            <p class="mt-1 font-semibold text-slate-800">admin@lenscamp.com</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">WhatsApp</p>
                            <p class="mt-1 font-semibold text-slate-800">081234567890</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-200 p-4">
                            <p class="text-sm text-slate-500">Jam Operasional</p>
                            <p class="mt-1 font-semibold text-slate-800">08:00 - 20:00 WIB</p>
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </main>
</body>
</html>