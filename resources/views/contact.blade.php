<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - LensCamp</title>

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
                <a href="{{ route('products') }}" class="text-sm font-medium text-slate-700 hover:text-blue-600 transition">Produk</a>
                <a href="{{ route('contact') }}" class="text-sm font-semibold text-blue-600">Hubungi Kami</a>
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
                <p class="text-sm font-medium text-blue-100">Hubungi Kami</p>
                <h2 class="mt-3 text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                    Kami siap membantu kebutuhan rental kamu.
                </h2>
                <p class="mt-5 text-sm sm:text-base text-blue-50 leading-7">
                    Hubungi admin kami untuk pertanyaan mengenai stok barang, jadwal sewa, ataupun bantuan pemesanan.
                </p>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
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

                <a href="https://wa.me/6281234567890"
                   target="_blank"
                   class="inline-flex rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                    Chat via WhatsApp
                </a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h3 class="text-2xl font-bold text-slate-800">Kirim Pesan</h3>
                <p class="mt-2 text-sm text-slate-500">Isi form berikut jika kamu ingin menghubungi kami.</p>

                <form class="mt-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                        <input type="text"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Masukkan nama">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Masukkan email">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Pesan</label>
                        <textarea rows="5"
                            class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Tulis pesan kamu"></textarea>
                    </div>

                    <button type="button"
                        class="rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </section>

    </main>
</body>
</html>