<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - LensCamp</title>

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
                <a href="{{ route('about') }}" class="text-sm font-semibold text-blue-600">Tentang</a>
                <a href="{{ route('products') }}" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Produk</a>
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

    <main class="max-w-screen-xl mx-auto px-4 sm:px-6 py-10 space-y-10">

        <section class="rounded-[28px] bg-gradient-to-r from-blue-600 to-blue-500 p-8 sm:p-10 text-white shadow-lg">
            <div class="max-w-3xl">
                <p class="text-sm font-medium text-blue-100">Tentang LensCamp</p>
                <h2 class="mt-3 text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    Solusi rental perlengkapan outdoor yang cepat, rapi, dan praktis.
                </h2>
                <p class="mt-5 text-sm sm:text-base text-blue-50 leading-7">
                    LensCamp hadir untuk memudahkan pelanggan dalam menyewa perlengkapan outdoor dan perlengkapan pendukung lainnya
                    dengan proses yang lebih sederhana, modern, dan efisien.
                </p>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm font-semibold text-blue-600">Visi</p>
                <h3 class="mt-2 text-2xl font-bold text-slate-800">Menjadi platform rental perlengkapan yang mudah diakses semua orang.</h3>
                <p class="mt-4 text-slate-600 leading-7">
                    Kami ingin membantu pelanggan menemukan dan menyewa perlengkapan yang dibutuhkan tanpa proses yang ribet.
                </p>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm font-semibold text-blue-600">Misi</p>
                <h3 class="mt-2 text-2xl font-bold text-slate-800">Menyediakan pengalaman sewa yang simpel dan terpercaya.</h3>
                <p class="mt-4 text-slate-600 leading-7">
                    Mulai dari pemilihan produk, penjadwalan sewa, hingga pembayaran, semua dirancang agar pelanggan bisa menyewa dengan nyaman.
                </p>
            </div>
        </section>

        <section class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Produk</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">50+</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Pelanggan</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">100+</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Transaksi</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">300+</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-5">
                    <p class="text-sm text-slate-500">Layanan</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">Cepat</p>
                </div>
            </div>
        </section>

    </main>
</body>
</html>