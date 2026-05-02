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

@php
    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500';
    $labelClass = 'block text-sm font-medium text-slate-700 mb-2';

    $features = [
        ['small'=>'Cepat','big'=>'Praktis'],
        ['small'=>'Sewa','big'=>'Online'],
        ['small'=>'Pantau','big'=>'Pesanan'],
    ];
@endphp

<body class="min-h-screen bg-slate-50 text-slate-800">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <div class="hidden lg:flex bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white p-12 flex-col justify-between">

        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center text-xl font-extrabold">
                    L
                </div>
                <div>
                    <h1 class="text-2xl font-bold">LensCamp</h1>
                    <p class="text-sm text-blue-100">Aplikasi Rental Outdoor</p>
                </div>
            </a>
        </div>

        <div class="max-w-xl">
            <p class="text-sm font-semibold text-blue-100">Pendaftaran Pelanggan</p>

            <h2 class="mt-3 text-4xl font-extrabold leading-tight">
                Daftar dan lengkapi biodata pelanggan.
            </h2>

            <p class="mt-5 text-base text-blue-50 leading-7">
                Data pelanggan digunakan untuk verifikasi, proses penyewaan, dan pengelolaan transaksi oleh admin.
            </p>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($features as $item)
                    <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                        <p class="text-sm text-blue-100">{{ $item['small'] }}</p>
                        <p class="mt-2 text-2xl font-bold">{{ $item['big'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-sm text-blue-100">
            © 2026 LensCamp. All rights reserved.
        </div>

    </div>

    <div class="flex items-center justify-center px-4 py-10 sm:px-6">
        <div class="w-full max-w-2xl">

            <div class="mb-8 lg:hidden">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-extrabold">
                        L
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">LensCamp</h1>
                        <p class="text-xs text-slate-500">Aplikasi Rental Outdoor</p>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-slate-800">Daftar Pelanggan</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Lengkapi data berikut untuk membuat akun pelanggan.
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
                        <label class="{{ $labelClass }}">Nama Lengkap</label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            class="{{ $inputClass }}">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="{{ $labelClass }}">Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                required
                                class="{{ $inputClass }}">
                        </div>

                        <div>
                            <label class="{{ $labelClass }}">Password</label>
                            <input
                                type="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                                class="{{ $inputClass }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="{{ $labelClass }}">Nomor KTP</label>
                            <input
                                type="text"
                                name="no_ktp"
                                value="{{ old('no_ktp') }}"
                                placeholder="Masukkan nomor KTP"
                                required
                                class="{{ $inputClass }}">
                        </div>

                        <div>
                            <label class="{{ $labelClass }}">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="{{ $inputClass }}">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="{{ $labelClass }}">Nomor Telepon</label>
                            <input
                                type="text"
                                name="no_telp"
                                value="{{ old('no_telp') }}"
                                placeholder="Masukkan nomor telepon"
                                required
                                class="{{ $inputClass }}">
                        </div>

                        <div>
                            <label class="{{ $labelClass }}">Nomor WhatsApp</label>
                            <input
                                type="text"
                                name="no_wa"
                                value="{{ old('no_wa') }}"
                                placeholder="Masukkan nomor WhatsApp"
                                required
                                class="{{ $inputClass }}">
                        </div>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Alamat</label>
                        <textarea
                            name="alamat"
                            rows="4"
                            placeholder="Masukkan alamat lengkap"
                            required
                            class="{{ $inputClass }}">{{ old('alamat') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700 transition">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    Sudah punya akun?
                    <a href="{{ route('login.pelanggan') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                        Masuk di sini
                    </a>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600">
                        Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>

</body>
</html>