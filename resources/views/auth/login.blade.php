<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

@php
    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-[#2F5249] focus:ring-[#2F5249]';
    $labelClass = 'block text-sm font-medium text-slate-700 mb-2';
    $heroBg = asset('images/background-camping-camera.jpeg');

    $stats = [
        ['label'=>'Produk','value'=>'50+'],
        ['label'=>'Pelanggan','value'=>'100+'],
        ['label'=>'Transaksi','value'=>'300+'],
    ];

    $formFields = [
        [
            'label'=>'Email',
            'type'=>'email',
            'name'=>'email',
            'value'=>old('email'),
            'placeholder'=>'Masukkan email'
        ],
        [
            'label'=>'Password',
            'type'=>'password',
            'name'=>'password',
            'value'=>'',
            'placeholder'=>'Masukkan password'
        ],
    ];
@endphp

<body class="min-h-screen bg-[#F8FAF7] text-slate-800">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <div
        class="hidden lg:flex text-white p-12 flex-col justify-between bg-cover bg-center relative overflow-hidden"
        style="background-image: linear-gradient(rgba(30,46,36,.80), rgba(30,46,36,.80)), url('{{ $heroBg }}')"
    >

        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-xl font-extrabold shadow backdrop-blur">
                    L
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">LensCamp</h1>
                    <p class="text-sm text-[#DDE8DF]">Aplikasi Rental Outdoor</p>
                </div>
            </a>
        </div>

        <div class="max-w-xl">
            <p class="text-sm font-semibold text-[#DDE8DF]">Selamat datang kembali</p>

            <h2 class="mt-3 text-4xl font-extrabold leading-tight">
                Login untuk mulai menyewa lebih cepat dan praktis.
            </h2>

            <p class="mt-5 text-base text-[#F1F6F2] leading-7">
                Akses produk, atur jadwal sewa, lihat pembayaran, dan pantau pesanan kamu dalam satu aplikasi.
            </p>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($stats as $item)
                    <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15 backdrop-blur">
                        <p class="text-sm text-[#DDE8DF]">{{ $item['label'] }}</p>
                        <p class="mt-2 text-2xl font-bold">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-sm text-[#DDE8DF]">
            © 2026 LensCamp. All rights reserved.
        </div>

    </div>

    <div class="flex items-center justify-center px-4 py-10 sm:px-6">
        <div class="w-full max-w-md">

            <div class="mb-8 lg:hidden">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#2F5249] text-white flex items-center justify-center font-extrabold">
                        L
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight text-[#2F5249]">LensCamp</h1>
                        <p class="text-xs text-slate-500">Aplikasi Rental Outdoor</p>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-[#2F5249]">Login</h2>
                </div>

                <div class="mb-5 rounded-2xl bg-blue-50 border border-blue-200 px-4 py-3 text-sm text-blue-700">
                Belum memiliki akun? Silakan daftar terlebih dahulu untuk melakukan penyewaan.
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

                <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                    @csrf

                    @foreach($formFields as $field)
                        <div>
                            <label class="{{ $labelClass }}">{{ $field['label'] }}</label>

                            <input
                                type="{{ $field['type'] }}"
                                name="{{ $field['name'] }}"
                                value="{{ $field['value'] }}"
                                placeholder="{{ $field['placeholder'] }}"
                                @if($field['name'] == 'password')
                                    minlength="6"
                                    maxlength="6"
                                    pattern=".{6}"
                                    title="Password harus tepat 6 karakter"
                                @endif
                                required
                                class="{{ $inputClass }}">

                            @if($field['name'] == 'password')
                                <p class="mt-1 text-xs text-slate-500">
                                    Password harus tepat 6 karakter
                                </p>
                            @endif
                        </div>
                    @endforeach

                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-[#2F5249] px-5 py-3 text-sm font-semibold text-white hover:bg-[#437057] transition">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-slate-500">
                    Belum punya akun?
                    <a href="{{ route('daftar') }}" class="font-semibold text-[#2F5249] hover:text-[#437057]">
                        Daftar di sini
                    </a>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-slate-600 hover:text-[#2F5249]">
                        ← Kembali ke Home
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>
</body>
</html>