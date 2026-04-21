<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

        <div class="hidden lg:flex bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white p-12 flex-col justify-between">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur text-white flex items-center justify-center text-xl font-extrabold shadow">
                        L
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">LensCamp</h1>
                        <p class="text-sm text-blue-100">Aplikasi Rental Outdoor</p>
                    </div>
                </a>
            </div>

            <div class="max-w-xl">
                <p class="text-sm font-semibold text-blue-100">Buat akun baru</p>
                <h2 class="mt-3 text-4xl font-extrabold leading-tight">
                    Daftar dan mulai gunakan LensCamp dengan mudah.
                </h2>
                <p class="mt-5 text-base text-blue-50 leading-7">
                    Setelah mendaftar, kamu bisa langsung memilih produk, menentukan jadwal sewa, dan memantau pembayaran dalam satu aplikasi.
                </p>

                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                        <p class="text-sm text-blue-100">Cepat</p>
                        <p class="mt-2 text-2xl font-bold">Praktis</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                        <p class="text-sm text-blue-100">Sewa</p>
                        <p class="mt-2 text-2xl font-bold">Online</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                        <p class="text-sm text-blue-100">Pantau</p>
                        <p class="mt-2 text-2xl font-bold">Pesanan</p>
                    </div>
                </div>
            </div>

            <div class="text-sm text-blue-100">
                © 2026 LensCamp. All rights reserved.
            </div>
        </div>

        <div class="flex items-center justify-center px-4 py-10 sm:px-6">
            <div class="w-full max-w-md">
                <div class="mb-8 lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-lg font-extrabold shadow">
                            L
                        </div>
                        <div>
                            <h1 class="text-xl font-bold tracking-tight">LensCamp</h1>
                            <p class="text-xs text-slate-500">Aplikasi Rental Outdoor</p>
                        </div>
                    </a>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
                    <div class="mb-6">
                        <h2 class="text-3xl font-bold text-slate-800">Daftar</h2>
                        <p class="mt-2 text-sm text-slate-500">
                            Buat akun baru untuk mulai menggunakan LensCamp.
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="mb-5 rounded-2xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('daftar.proses') }}" method="POST" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan email">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                            <input type="password" name="password"
                                class="w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Masukkan password">
                        </div>

                        <button type="submit"
                            class="w-full rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                            Daftar Sekarang
                        </button>
                    </form>

                    <div class="mt-6 text-center text-sm text-slate-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                            Masuk di sini
                        </a>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600">
                            ← Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>