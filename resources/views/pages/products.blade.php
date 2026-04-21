<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-extrabold shadow">
                    L
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight">LensCamp</h1>
                    <p class="text-xs text-slate-500">Sewa perlengkapan dengan cepat</p>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Beranda</a>
                <a href="{{ route('about') }}" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Tentang</a>
                <a href="{{ route('products') }}" class="text-sm font-semibold text-blue-600">Produk</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Hubungi Kami</a>
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
        </div>
    </header>

    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 py-10 space-y-8">

        <section class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-8 sm:p-10 text-white shadow-lg">
            <div class="max-w-3xl">
                <p class="text-sm font-medium text-blue-100">Katalog Produk</p>
                <h2 class="mt-3 text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    Pilih perlengkapan terbaik sesuai kebutuhanmu.
                </h2>
                <p class="mt-5 text-sm sm:text-base text-blue-50 leading-7">
                    Jelajahi produk rental yang tersedia dan temukan perlengkapan yang paling cocok untuk kegiatan kamu.
                </p>
            </div>
        </section>

        <section class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text"
                    placeholder="Cari produk..."
                    class="rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">

                <select class="rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option>Semua Kategori</option>
                    <option>Tas</option>
                    <option>Tenda</option>
                    <option>Aksesoris</option>
                </select>

                <select class="rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option>Urutkan</option>
                    <option>Harga Termurah</option>
                    <option>Harga Termahal</option>
                    <option>Stok Terbanyak</option>
                </select>
            </div>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @php
                $produk = [
                    [
                        'nama' => 'Tas Slempang',
                        'kategori' => 'Tas',
                        'deskripsi' => 'Tas untuk perlengkapan outdoor.',
                        'harga' => 12000,
                        'stok' => 10,
                    ],
                    [
                        'nama' => 'Tenda 4 Orang',
                        'kategori' => 'Tenda',
                        'deskripsi' => 'Tenda camping untuk kebutuhan outdoor.',
                        'harga' => 100000,
                        'stok' => 8,
                    ],
                    [
                        'nama' => 'Tripod Kamera',
                        'kategori' => 'Aksesoris',
                        'deskripsi' => 'Tripod stabil untuk hasil foto dan video.',
                        'harga' => 55000,
                        'stok' => 15,
                    ],
                ];
            @endphp

            @foreach($produk as $item)
                <div class="bg-white rounded-3xl border border-slate-200 p-5 shadow-sm hover:shadow-md transition">
                    <div class="h-44 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-4xl font-bold">
                        {{ strtoupper(substr($item['nama'], 0, 1)) }}
                    </div>

                    <div class="mt-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $item['nama'] }}</h4>
                                <p class="text-sm text-slate-500 mt-1">{{ $item['kategori'] }}</p>
                            </div>
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                Stok {{ $item['stok'] }}
                            </span>
                        </div>

                        <p class="mt-3 text-sm text-slate-500">
                            {{ $item['deskripsi'] }}
                        </p>

                        <p class="mt-4 text-base font-bold text-blue-600">
                            Rp {{ number_format($item['harga'], 0, ',', '.') }} / hari
                        </p>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <a href="{{ route('login') }}"
                               class="rounded-xl bg-blue-600 px-4 py-3 text-center text-sm font-semibold text-white hover:bg-blue-700 transition">
                                Sewa
                            </a>

                            <a href="{{ route('contact') }}"
                               class="rounded-xl bg-slate-100 px-4 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-200 transition">
                                Tanya Admin
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>

    </main>
</body>
</html>