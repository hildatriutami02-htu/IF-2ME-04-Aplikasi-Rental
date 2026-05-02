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

@php
    $publicNav = [
        ['href' => '#beranda', 'label' => 'Beranda'],
        ['href' => '#tentang', 'label' => 'Tentang'],
        ['href' => '#produk', 'label' => 'Produk'],
        ['href' => '#hubungi-kami', 'label' => 'Hubungi Kami'],
    ];

    $aboutStats = [
        ['label' => 'Produk Tersedia', 'value' => '50+'],
        ['label' => 'Pelanggan', 'value' => '100+'],
        ['label' => 'Transaksi', 'value' => '300+'],
        ['label' => 'Layanan', 'value' => 'Cepat'],
    ];

    $contactItems = [
        ['label' => 'Email', 'value' => 'admin@lenscamp.com'],
        ['label' => 'WhatsApp', 'value' => '081234567890'],
        ['label' => 'Jam Operasional', 'value' => '08:00 - 20:00 WIB'],
    ];

    $productInputClass = 'w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500';
@endphp

<body class="bg-slate-50 text-slate-800">

    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto grid max-w-screen-2xl grid-cols-[auto_1fr_auto] items-center gap-6 px-4 py-4 sm:px-6">

            <a href="{{ route('home') }}" class="flex items-center gap-3 whitespace-nowrap">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-lg font-extrabold text-white shadow">
                    L
                </div>

                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-800">LensCamp</h1>
                    <p class="text-xs text-slate-500">
                        {{ $isPelanggan ? 'Ruang Pelanggan' : 'Sewa perlengkapan dengan cepat' }}
                    </p>
                </div>
            </a>

            @if($isPelanggan)
                <nav class="hidden items-center justify-center gap-2 whitespace-nowrap lg:flex">
                    <a href="{{ route('pelanggan.dashboard') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
                        Beranda
                    </a>

                    <a href="{{ route('pelanggan.produk') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
                        Produk
                    </a>

                    <a href="{{ route('pelanggan.keranjang') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
                        Keranjang
                    </a>

                    <a href="{{ route('pelanggan.sewa') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
                        Sewa Saya
                    </a>

                    <a href="{{ route('pelanggan.pembayaran') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
                        Pembayaran
                    </a>

                    <a href="{{ route('pelanggan.riwayat') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
                        Riwayat
                    </a>

                    <a href="{{ route('pelanggan.hubungi-admin') }}"
                       class="rounded-xl px-4 py-2 text-sm font-medium transition text-slate-700 hover:bg-slate-100">
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
            @else
                <nav class="flex justify-center items-center gap-6 w-full">
                    @foreach($publicNav as $item)
                      <a href="{{ $item['href'] }}"
                        class="menu-link text-sm font-medium text-slate-700 px-3 py-2 rounded-xl transition hover:bg-blue-100">
                          {{ $item['label'] }}
                      </a>
                    @endforeach
                </nav>

                <div class="flex items-center justify-end gap-3 whitespace-nowrap">
                    <a href="{{ route('login') }}"
                       class="inline-flex rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                        Masuk
                    </a>

                    <a href="{{ route('daftar') }}"
                       class="inline-flex rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Daftar
                    </a>
                </div>
            @endif
        </div>

        @if($isPelanggan)
            <div class="border-t border-slate-200 bg-white lg:hidden">
                <div class="mx-auto flex max-w-screen-2xl gap-2 overflow-x-auto px-4 py-3 sm:px-6">
                    <a href="{{ route('pelanggan.dashboard') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Beranda
                    </a>

                    <a href="{{ route('pelanggan.produk') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Produk
                    </a>

                    <a href="{{ route('pelanggan.keranjang') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Keranjang
                    </a>

                    <a href="{{ route('pelanggan.sewa') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Sewa Saya
                    </a>

                    <a href="{{ route('pelanggan.pembayaran') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Pembayaran
                    </a>

                    <a href="{{ route('pelanggan.riwayat') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Riwayat
                    </a>

                    <a href="{{ route('pelanggan.hubungi-admin') }}" class="whitespace-nowrap rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700">
                        Bantuan
                    </a>
                </div>
            </div>
        @endif
    </header>

    <main class="mx-auto max-w-screen-2xl px-4 py-8 sm:px-6 space-y-16">

        @if(session('success'))
            <div class="rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($isPelanggan)
            <section id="beranda" class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-lg sm:p-8">
                <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <p class="text-sm font-medium text-blue-100">
                            Halo, {{ session('user') ?? 'Pelanggan' }}
                        </p>

                        <h2 class="mt-2 text-3xl font-extrabold leading-tight tracking-tight sm:text-4xl">
                            Mau sewa apa hari ini?
                        </h2>

                        <p class="mt-3 max-w-2xl text-sm text-blue-50 sm:text-base">
                            Pilih produk, tentukan tanggal sewa, lalu tambahkan ke keranjang sebelum checkout.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-3">
                            <a href="#produk"
                               class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 transition hover:bg-slate-100">
                                Lihat Produk
                            </a>

                            <a href="{{ route('pelanggan.hubungi-admin') }}"
                               class="rounded-2xl bg-blue-700/40 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/20 transition hover:bg-blue-700/60">
                                Hubungi Admin
                            </a>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white/10 p-5 ring-1 ring-white/15 backdrop-blur">
                        <h3 class="text-lg font-bold">Ringkasan Akun</h3>

                        <div class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                                <span>Sewa Aktif</span>
                                <span class="font-bold">{{ count($customerRentals ?? []) }}</span>
                            </div>

                            <div class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3">
                                <span>Pembayaran</span>
                                <span class="font-bold">{{ count($paymentHistory ?? []) }}</span>
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
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
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
                           class="inline-flex w-fit rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Lihat Pesanan
                        </a>
                    </div>
                </section>
            @endif
        @else
            <section id="beranda" class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white shadow-lg sm:p-10">
                <div class="max-w-3xl">
                    <p class="text-sm font-medium text-blue-100">Outdoor & Visual Rental</p>

                    <h2 class="mt-2 text-3xl font-extrabold leading-tight tracking-tight sm:text-5xl">
                        Sewa perlengkapan lebih cepat dan lebih praktis.
                    </h2>

                    <p class="mt-4 max-w-2xl text-sm text-blue-50 sm:text-base">
                        Login untuk langsung memesan produk, pilih tanggal sewa, dan pantau pembayaran dari satu beranda aplikasi.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('login') }}"
                           class="rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-blue-700 transition hover:bg-slate-100">
                            Masuk Sekarang
                        </a>

                        <a href="{{ route('daftar') }}"
                           class="rounded-2xl bg-blue-700/40 px-5 py-3 text-sm font-semibold text-white ring-1 ring-white/20 transition hover:bg-blue-700/60">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </section>

            <section id="tentang" class="grid grid-cols-1 items-center gap-6 lg:grid-cols-2">
                <div>
                    <p class="text-sm font-semibold text-blue-600">Tentang LensCamp</p>

                    <h3 class="mt-2 text-3xl font-bold text-slate-800">
                        Rental perlengkapan outdoor yang simpel dan cepat.
                    </h3>

                    <p class="mt-4 leading-7 text-slate-600">
                        LensCamp membantu pelanggan menyewa perlengkapan outdoor dan perlengkapan visual dengan proses yang lebih mudah.
                        Mulai dari pilih produk, tentukan tanggal sewa, hingga pembayaran, semua dilakukan dalam satu alur yang sederhana.
                    </p>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($aboutStats as $stat)
                            <div class="rounded-2xl bg-slate-50 p-5">
                                <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                                <p class="mt-2 text-2xl font-bold text-slate-800">{{ $stat['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section id="produk" class="space-y-5">
            <div>
                <h3 class="text-2xl font-bold text-slate-800">
                    {{ $isPelanggan ? 'Pesan Produk Sekarang' : 'Produk Populer' }}
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $isPelanggan ? 'Pilih produk dan tambahkan ke keranjang sebelum checkout.' : 'Jelajahi perlengkapan terbaik yang tersedia.' }}
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
                @foreach($products as $item)
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                        <div class="flex h-44 items-center justify-center rounded-2xl bg-slate-100 text-4xl font-bold text-slate-400">
                            {{ strtoupper(substr($item['nama_barang'], 0, 1)) }}
                        </div>

                        <div class="mt-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h4 class="text-lg font-bold text-slate-800">
                                        {{ $item['nama_barang'] }}
                                    </h4>

                                    <p class="mt-1 text-sm text-slate-500">
                                        {{ $item['jenis_barang'] }}
                                    </p>
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
                            <form action="{{ route('pelanggan.keranjang.tambah') }}" method="POST" class="mt-5 space-y-3">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $item['id'] }}">

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-600">
                                            Tanggal Pinjam
                                        </label>

                                        <input type="date" name="tanggal_pinjam" class="{{ $productInputClass }}">
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-600">
                                            Tanggal Kembali
                                        </label>

                                        <input type="date" name="tanggal_kembali" class="{{ $productInputClass }}">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-[110px_1fr]">
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-600">
                                            Qty
                                        </label>

                                        <input type="number" name="qty" min="1" max="{{ $item['unit'] }}" value="1" class="{{ $productInputClass }}">
                                    </div>

                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-slate-600">
                                            Catatan
                                        </label>

                                        <input type="text" name="catatan" placeholder="Opsional" class="{{ $productInputClass }}">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit"
                                            class="rounded-xl bg-blue-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                                        Tambah Keranjang
                                    </button>

                                    <a href="{{ route('pelanggan.hubungi-admin') }}"
                                       class="rounded-xl bg-blue-800 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-900">
                                        Tanya Admin
                                    </a>
                                </div>
                            </form>
                            @else
                            <div class="mt-5 grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}"
                                 class="rounded-xl bg-blue-600 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700">
                                 Masuk
                            </a>

                             <a href="#hubungi-kami"
                                class="rounded-xl bg-blue-800 px-4 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-900">
                               Tanya Admin
                            </a>
                            </div>
                            @endif
                    </div>
                @endforeach
            </div>
        </section>

        @if(!$isPelanggan)
            <section id="hubungi-kami" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="grid grid-cols-1 items-center gap-6 lg:grid-cols-2">
                    <div>
                        <p class="text-sm font-semibold text-blue-600">Hubungi Kami</p>

                        <h3 class="mt-2 text-3xl font-bold text-slate-800">
                            Butuh bantuan sebelum menyewa?
                        </h3>

                        <p class="mt-4 leading-7 text-slate-600">
                            Hubungi admin kami untuk tanya stok barang, durasi sewa, atau bantuan proses pemesanan.
                        </p>
                    </div>

                    <div class="space-y-4">
                        @foreach($contactItems as $contact)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ $contact['label'] }}</p>
                                <p class="mt-1 font-semibold text-slate-800">{{ $contact['value'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>
    <script>
    const links = document.querySelectorAll('.menu-link');

    links.forEach(link => {
        link.addEventListener('click', function () {
            links.forEach(l => {
                l.classList.remove('bg-blue-600', 'text-white');
            });

            this.classList.add('bg-blue-600', 'text-white');
        });
    });
</script>

</body>
</html>