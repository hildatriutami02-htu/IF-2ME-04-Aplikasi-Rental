<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - LensCamp</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

@php
    $inputClass = 'w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm focus:border-blue-500 focus:ring-blue-500';
    $labelClass = 'block text-sm font-medium text-slate-700 mb-2';

    $stats = [
        ['label'=>'Produk','value'=>'50+'],
        ['label'=>'Pelanggan','value'=>'100+'],
        ['label'=>'Transaksi','value'=>'300+'],
    ];

    $formFields = [
        [
            'label'=>'Email Admin',
            'type'=>'email',
            'name'=>'email',
            'value'=>old('email'),
            'placeholder'=>'Masukkan email admin'
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

<body class="min-h-screen bg-slate-50 text-slate-800">

<div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- LEFT -->
    <div class="hidden lg:flex bg-gradient-to-br from-blue-700 via-blue-600 to-blue-500 text-white p-12 flex-col justify-between">

        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white/15 flex items-center justify-center text-xl font-extrabold shadow">
                    L
                </div>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">LensCamp</h1>
                    <p class="text-sm text-blue-100">Aplikasi Rental Outdoor</p>
                </div>
            </a>
        </div>

        <div class="max-w-xl">
            <p class="text-sm font-semibold text-blue-100">Akses administrator</p>

            <h2 class="mt-3 text-4xl font-extrabold leading-tight">
                Login admin untuk mengelola data dan transaksi LensCamp.
            </h2>

            <p class="mt-5 text-base text-blue-50 leading-7">
                Kelola produk, pelanggan, penyewaan, pembayaran, dan laporan dalam satu dashboard admin yang terintegrasi.
            </p>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($stats as $item)
                    <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                        <p class="text-sm text-blue-100">{{ $item['label'] }}</p>
                        <p class="mt-2 text-2xl font-bold">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-sm text-blue-100">
            © 2026 LensCamp. All rights reserved.
        </div>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center justify-center px-4 py-10 sm:px-6">
        <div class="w-full max-w-md">

            <!-- MOBILE LOGO -->
            <div class="mb-8 lg:hidden">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-extrabold">
                        L
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-tight">LensCamp</h1>
                        <p class="text-xs text-slate-500">Aplikasi Rental Outdoor</p>
                    </div>
                </a>
            </div>

            <!-- CARD -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-slate-800">Masuk Admin</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Login untuk melanjutkan ke dashboard administrator LensCamp.
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

                <form action="{{ route('login.admin.proses') }}" method="POST" class="space-y-5">
                    @csrf

                    @foreach($formFields as $field)
                        <div>
                            <label class="{{ $labelClass }}">{{ $field['label'] }}</label>
                            <input
                                type="{{ $field['type'] }}"
                                name="{{ $field['name'] }}"
                                value="{{ $field['value'] }}"
                                placeholder="{{ $field['placeholder'] }}"
                                class="{{ $inputClass }}">
                        </div>
                    @endforeach

                    <button type="submit"
                        class="w-full rounded-2xl bg-blue-800 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-900 transition inline-flex items-center justify-center">
                        Masuk Admin
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-blue-600">
                        ← Kembali pilih login
                    </a>
                </div>

            </div>
        </div>
    </div>

</div>
</body>
</html>